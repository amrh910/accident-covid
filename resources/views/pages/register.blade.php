@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-title">
                <h1>Sign Up</h1>
            </div>
            <div class="card-body">
                <form id="register" method="POST" action="/register">
                    @csrf
                    <p class="text-danger pass-error" id="no-match">Passwords do not match.</p>
                    <input class="form-control" type="text" placeholder="Name" name="name" id="name" required>
                    <input class="form-control" type="email" placeholder="Email" name="email" id="email" required>
                    <input class="form-control" type="password" placeholder="Password" name="password" id="password" required>
                    <input class="form-control" type="password" placeholder="Confirm Password" name="confirm-password" id="confirm-password" required>
                    <br>
                    <button type="button" onclick="registerValide();" class="btn btn-login">Register</button>
                </form>
            </div>
        </div>
    </div>
@endsection