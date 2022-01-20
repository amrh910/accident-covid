@extends('layouts.default')

@section('content')
    <style>
        
    </style>

    <div class="container">
        <div class="card">
            <div class="card-title">
                <h1>Login</h1>
            </div>
            <div class="card-body">
                <form id="login-form" method="POST" action="/login">
                    @csrf
                    <input class="form-control" type="email" placeholder="Email" name="email" id="email" required>
                    <input class="form-control" type="password" placeholder="Password" name="password" id="password" required>
                    <br>
                    <button type="submit" class="btn btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection