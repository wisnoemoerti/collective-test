@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Withdraw</div>

                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <form action="{{ route('withdraw') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Withdraw Amount </label>
                                <input type="number" class="form-control" id="amount" name="amount" min="0"
                                    step="0.01" placeholder="Amount">
                            </div>
                            <button class="btn btn-primary mt-2" type="submit">Withdraw</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
