<?php

namespace App\Http\Controllers;

use App\Services\ThirdPartyService;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use DB;

class PaymentController extends Controller
{
    protected $thirdPartyService;

    public function __construct(ThirdPartyService $thirdPartyService)
    {
        $this->thirdPartyService = $thirdPartyService;
    }

    public function dashboard()
    {
        $transactions = Transaction::all();
        return view('dashboard', compact('transactions'));
    }
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $orderId = uniqid();
        $amount = $request->input('amount');
        $timestamp = Carbon::now()->timestamp;

        DB::transaction(function () use ($orderId, $amount, $timestamp) {
            $response = $this->thirdPartyService->deposit($orderId, $amount, $timestamp);

            if ($response['status'] == 1) {
                $transaction = new Transaction();
                $transaction->user_id = auth()->id();
                $transaction->order_id = $orderId;
                $transaction->amount = $amount;
                $transaction->type = 'Deposit';
                $transaction->timestamp = Carbon::createFromTimestamp($timestamp);
                $transaction->status = 1;
                $transaction->save();

                $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
                $wallet->balance += $amount;
                $wallet->save();
            } else {
                // Handle failed transaction
            }
        });

        return redirect()->back()->with('message', 'Deposit successful!');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $amount = $request->input('amount');

        DB::transaction(function () use ($amount) {
            $wallet = Wallet::where('user_id', auth()->id())->lockForUpdate()->first();

            if ($wallet->balance >= $amount) {
                $wallet->balance -= $amount;
                $wallet->save();

                $transaction = new Transaction();
                $transaction->user_id = auth()->id();
                $transaction->order_id = uniqid();
                $transaction->amount = $amount;
                $transaction->type = 'Withdraw';
                $transaction->timestamp = now();
                $transaction->status = 1;
                $transaction->save();
            } else {
                $transaction = new Transaction();
                $transaction->user_id = auth()->id();
                $transaction->order_id = uniqid();
                $transaction->amount = $amount;
                $transaction->type = 'Withdraw';
                $transaction->timestamp = now();
                $transaction->status = 2;
                $transaction->save();
            }
        });

        return redirect()->back()->with('message', 'Withdrawal successful!');
    }
}
