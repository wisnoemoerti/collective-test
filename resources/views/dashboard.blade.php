@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h1>Transaction History</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Timestamp</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->order_id }}</td>
                                        <td>{{ 'Rp ' . number_format($transaction->amount, 2, ',', '.') }}</td>
                                        <td>{{ date('d F Y H:i:s', strtotime($transaction->timestamp)) }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td><span class="alert alert-{{ $transaction->status == 1 ? 'success' : 'danger' }}"
                                                style="padding:1px !important ">{{ $transaction->status == 1 ? 'Success' : 'Failed' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
