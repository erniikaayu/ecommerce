<!-- resources/views/pages/login.blade.php -->
@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
    .card {
        border: none;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <x-input 
                            input-type="email" 
                            input-name="email" 
                            input-class="" 
                            placeholder="" 
                            label="email"
                        />
                        <x-input 
                            input-type="password" 
                            input-name="password" 
                            input-class="" 
                            placeholder="" 
                            label="password"
                        />
                        <x-input 
                            input-type="password" 
                            input-name="password_confirmation" 
                            input-class="" 
                            placeholder="" 
                            label="Ulang Password"
                        />
                        <x-button 
                            class-name="btn btn-primary w-100 mb-2" 
                            button-type="submit" 
                            label="Login"
                        />
                        <x-button 
                            class-name="btn btn-success w-100" 
                            button-type="button" 
                            label="Register"
                        />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection