<?php

namespace App\Controllers;

use App\Models\SubscriptionModel;
use App\Config\Midtrans;

class PaymentController extends BaseController
{
    public function __construct()
    {
        // Load konfigurasi Midtrans
        $midtrans = new Midtrans();
    }

    public function checkout()
    {
        $userId = session()->get('user_id');
        $amount = 100000; 

        // Data transaksi
        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => $amount,
        ];

        $itemDetails = [
            [
                'id' => 'sub1',
                'price' => $amount,
                'quantity' => 1,
                'name' => 'Langganan Pro 3 Bulan',
            ],
        ];

        $customerDetails = [
            'first_name' => session()->get('user_name'), 
            'email' => session()->get('user_email'), 
        ];

        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        // Generate Snap Token
        $snapToken = \Midtrans\Snap::getSnapToken($transactionData);

        return view('checkout', ['snapToken' => $snapToken, 'amount' => $amount]);
    }

    public function paymentNotification()
    {
        // Menangani notifikasi dari Midtrans
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);

        if ($result && $result->status_code == '200') {
            $order_id = $result->order_id;

            // Update status subscription di database
            $subscriptionModel = new SubscriptionModel();
            $subscriptionModel->where('order_id', $order_id)
                              ->set(['status' => 'active'])
                              ->update();

            // Update role user menjadi pro
            $userModel = new \App\Models\UserModel();
            $userModel->where('id', $result->user_id)
                      ->set(['role' => 'pro', 'badge' => 'pro'])
                      ->update();
        }

        return 'OK';
    }
}