@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')

<div class="container">
        <h1>Deposit</h1>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <form method="post" action="{{ route('deposit') }}">
            @csrf
          
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Deposit</button>
        </form>
    </div>
    <div class="container mt-5">
        <h1>Deposited Transactions</h1>
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
                @foreach($deposits as $deposit)
                    <tr>
                        <td>{{ $deposit->transaction_type }}</td>
                        <td>{{ $deposit->amount }}</td>
                        <td>{{ $deposit->fee }}</td>
                        <td>{{ $deposit->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection