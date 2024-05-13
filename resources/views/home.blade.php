@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">

                    <div class="row mb-4">
            <div class="col-md-4">
                <a href="{{ url('/deposit') }}" class="btn btn-primary">Deposit</a>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ url('/withdrawal') }}" class="btn btn-danger">Withdrawal</a>
            </div>
        </div>
        <h1>All Transactions</h1>
        <h3>Current Balance: {{Auth::user()->balance}} </h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Transaction Type</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                  
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_type }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->fee }}</td>
                            <td>{{ $transaction->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
