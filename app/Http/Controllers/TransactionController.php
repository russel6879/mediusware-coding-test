<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function deposit(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
           
            'amount' => 'required|numeric|min:0',
        ]);

        // Find the user by ID
        $user = User::findOrFail(Auth::user()->id);

        // Update the user's balance
        $user->balance += $request->amount;
        $user->save();

        // Create a transaction record
        $transaction = Transactions::insert([
            'user_id' => $user->id,
            'transaction_type' => 'deposit',
            'amount' => $request->amount,
            'fee' => 0, // Assuming no fee for deposit
            'date' => now(),
        ]);

        return redirect()->back()->with('success', 'Deposit successful');
    }

    public function showWithdrawals()
    {
        // Fetch all withdrawal transactions
        $withdrawals = Transactions::where('transaction_type', 'withdrawal')->where('user_id',Auth::user()->id)->get();

        // Return the view with withdrawal transactions
        return view('withdrawals', compact('withdrawals'));
    }
     public function showDeposits()
     {
         // Fetch all deposited transactions
         $deposits = Transactions::where('transaction_type', 'deposit')->where('user_id',Auth::user()->id)->get();
 
         // Pass deposits to the view
         return view('deposits', compact('deposits'));
     }


     public function withdraw(Request $request)
     {
         // Validate the incoming request data
         $request->validate([
          
             'amount' => 'required|numeric|min:0',
         ]);
 
         // Find the user by ID
         $user = User::findOrFail(Auth::user()->id);
 
         // Calculate the withdrawal fee based on the user's account type
         $withdrawalFee = $this->calculateWithdrawalFee($user, $request->amount);
 
         // Update the user's balance after deducting the amount and fee
         $user->balance -= ($request->amount + $withdrawalFee);
         $user->save();
 
         // Create a transaction record for the withdrawal
         $transaction = Transactions::insert([
             'user_id' => $user->id,
             'transaction_type' => 'withdrawal',
             'amount' => $request->amount,
             'fee' => $withdrawalFee,
             'date' => now(),
         ]);
 
         // Return a success response
      
         return redirect()->back()->with('success', 'Withdrawal successful');
     }
 
     // Method to calculate the withdrawal fee based on user's account type and withdrawal amount
     private function calculateWithdrawalFee($user, $amount)
     {
         $withdrawalFee = 0;
 
         // Apply withdrawal rate based on account type
         if ($user->account_type == 'Individual') {
             $withdrawalFee = $this->calculateIndividualWithdrawalFee($amount);
         } elseif ($user->account_type == 'Business') {
             $withdrawalFee = $this->calculateBusinessWithdrawalFee($user, $amount);
         }
 
         return $withdrawalFee;
     }
 
     // Method to calculate withdrawal fee for Individual accounts
     private function calculateIndividualWithdrawalFee($amount)
     {
         // Check if it's Friday and apply free withdrawal condition
         if (Carbon::now()->isFriday()) {
             return 0;
         }
 
         // Apply free withdrawal condition for the first 1K withdrawal per transaction
         if ($amount <= 1000) {
             return 0;
         }
 
         // Apply free withdrawal condition for the first 5K withdrawal each month
         if (Transactions::where('transaction_type', 'withdrawal')
             ->where('user_id', auth()->id())
             ->whereMonth('date', now()->month)
             ->sum('amount') <= 5000) {
             return 0;
         }
 
         // Otherwise, apply the regular withdrawal fee
         return $amount * 0.00015;
     }
 
     // Method to calculate withdrawal fee for Business accounts
     private function calculateBusinessWithdrawalFee($user, $amount)
     {
         // Check if the total withdrawal exceeds 50K and decrease the withdrawal fee
         if (Transactions::where('transaction_type', 'withdrawal')->where('user_id', $user->id)->sum('amount') > 50000) {
             return $amount * 0.00015;
         }
 
         // Otherwise, apply the regular withdrawal fee
         return $amount * 0.00025;
     }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
}
