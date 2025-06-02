@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Users</span>
            <a class="btn btn-primary" href="{{route('user.create')}}">Create User</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <select class="form-select" id="filterName">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterEmail">
                        <option value="">All Emails</option>
                        @foreach($users as $user)
                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterRole">
                        <option value="all">All Roles</option>
                        <option value="1">Admin</option>
                        <option value="0">User</option>
                    </select>
                </div>

                <div class="col-md-12 col-sm-12 mt-5" >
                    <table class="table table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <!-- <  th>Action</th> -->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    let table = $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('users') }}",
            data: function(d) {
                d.name = $('#filterName').val();
                d.email = $('#filterEmail').val();
                d.role = $('#filterRole').val();
            }
        },
        columns: [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'role',
                name: 'is_admin'
            }
            // {
            //     data: 'roale',
            //     name: 'is_admin'
            // }
        ]
    });

    $('#filterName, #filterEmail, #filterRole').on('change', function() {
        table.draw();
    });
});
</script>
@endpush