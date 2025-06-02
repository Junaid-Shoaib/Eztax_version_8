@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Clients</span>
            <a class="btn btn-sm btn-primary" href="{{route('clients.create')}}">Create Client</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12 col-sm-12 mt-3">
                    <table class="table table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <table class="table table-hover">
    <tr>
        <th width="10%">S.no.</th>
        <th>Name</th>
        <th>Category</th>
        <th>Location</th>
        <th width="20%">Actions</th>
    </tr>
    @foreach ($clients as $client)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $client->name }}</td>
        <td>{{ $client->category }}</td>
        <td>{{ $client->location }}</td>
        <td class="d-flex justify-content-around">
            <a class="btn btn-secondary" href="{{ route('clients.edit', $client->id) }}">Edit</a>
            <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table> --}}

@push('js')
<script>
$(document).ready(function() {
    let table = $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('clients') }}",
        },
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'category',
                name: 'category'
            },
            {
                data: 'location',
                name: 'location'
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });
});
</script>
@endpush
@endsection
