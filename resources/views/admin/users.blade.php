@extends('layout.back.master')
@section('title','Users')
@section('content')

<div class="container mt-5 text-center">
    {{-- <h2>Welcome, {{ auth()->user()->name }} 👋</h2>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger mt-3">Logout</button>
    </form>

    <hr class="my-4"> --}}

    <h3>All Registered Users</h3>
    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
