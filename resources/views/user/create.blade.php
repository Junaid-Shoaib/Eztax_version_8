@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>User Create</span>
                <a class="btn btn-primary" href="{{route('users')}}">Users</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your full Name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group mt-3">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                    placeholder="name@example.com">
                            </div>
                            <div class="form-group mt-3">
                                <label for="is_admin">Role</label>
                                <select class="form-control" id="is_admin" name="is_admin">
                                    <option value="0" {{ old('is_admin') == 0 ? 'selected' : '' }}>User</option>
                                    <option value="1" {{ old('is_admin') == 1 ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group mt-3">
                                <label for="password_confirmation">Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm password">
                            </div>
                            <div class="form-group mt-3">
                                <label for="password_confirmation">Location</label>
                                <select class="form-select" id="location" name="location">
                                    <option value="Karachi">Karachi</option>
                                    <option value='Islamabad'>Islamabad</option>
                                    <option value='Lahore'>Lahore</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection