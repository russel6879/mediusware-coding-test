@extends('layouts.app')

@section('content')

<div class="container">
        <h1>Withdrawal</h1>
        {{-- Display success message if it exists --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <form method="post" action="{{ route('withdrawal') }}">
            @csrf
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Withdraw</button>
        </form>
    </div>
    <div class="container mt-5">
        <h1>Withdrawal Transactions</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                    <th>Fee</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $withdrawal)
                    <tr>
                        <td>{{ $withdrawal->transaction_type }}</td>
                        <td>{{ $withdrawal->amount }}</td>
                        <td>{{ $withdrawal->fee }}</td>
                        <td>{{ $withdrawal->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
