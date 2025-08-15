@extends('layouts.app')

@section('title', 'Help & Contact')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h2 class="mb-3">Help & Contact</h2>
        <p>If you have any questions or face issues during voter registration, please contact us:</p>

        <ul class="list-group">
            <li class="list-group-item"><strong>Helpline Number:</strong> +91 98765 43210</li>
            <li class="list-group-item"><strong>Email:</strong> help@voterportal.in</li>
            <li class="list-group-item"><strong>Office Address:</strong> Election Office, Main Street, Your City</li>
        </ul>

        <hr>
        <h5>Submit a Query</h5>
        <form>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label>Message</label>
                <textarea class="form-control" rows="4" placeholder="Enter your message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</div>
@endsection
    