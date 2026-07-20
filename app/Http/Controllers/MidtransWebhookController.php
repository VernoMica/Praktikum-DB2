<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Log: Webhook diterima
        Log::info('=== MIDTRANS WEBHOOK RECEIVED ===');
        
        $payload = $request->all();
        Log::info('Midtrans Payload:', $payload);
        
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        
        Log::info("Order ID: {$orderId} | Status: {$transactionStatus} | Fraud: {$fraudStatus}");
        
        if (!$orderId) {
            Log::warning('Midtrans Webhook: Invalid payload - no order_id');
            return response()->json(['message' => 'Invalid payload'], 400);
        }
        
        // Mencari ID transaksi tersebut di database lokal kita
        $transaction = Transaction::with('event')->where('order_id',
            $orderId)->first();
        
        if (!$transaction) {
            Log::warning("Midtrans Webhook: Transaction not found for order_id: {$orderId}");
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        
        Log::info("Transaction found: ID={$transaction->id} | Current Status={$transaction->status}");
        
        // Cegah proses berulang jika status sudah lunas/sukses
        if ($transaction->status === 'settlement' || $transaction->status === 'success') {
            Log::info("Midtrans Webhook: Already processed for order_id: {$orderId}");
            return response()->json(['message' => 'Already processed']);
        }
        
        // Logika Penerjemahan Status Midtrans API
        $oldStatus = $transaction->status;
        
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->status = 'settlement';
            $this->processSuccess($transaction);
        } else if (in_array($transactionStatus, ['cancel', 'deny','expire'])) {
            $transaction->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        }
        
        $transaction->save();
        
        Log::info("Midtrans Webhook: Status updated {$oldStatus} -> {$transaction->status} for order_id: {$orderId}");
        Log::info('=== MIDTRANS WEBHOOK DONE ===');
        
        return response()->json(['message' => 'OK']);
    }
    
    private function processSuccess(Transaction $transaction)
    {
        $event = $transaction->event;

        // Jika tiket masih ada dan terhubung dengan data event, kurangi jumlahnya sebanyak 1
        if ($event && $event->stock > 0) {
            $event->stock = $event->stock - 1;
            $event->save();

            // Mengirimkan email E-Ticket ke pelanggan
            try {
                \Illuminate\Support\Facades\Mail::to($transaction->customer_email)->send(new \App\Mail\EventTicketMail($transaction));
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
            }
        } else {
            \Log::warning('Stock habis setelah pembayaran berhasil (Perlu proses refund opsional). Order: ' . $transaction->order_id);
        }
    }
}