@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="m-2">
            <div class="p-2">
                <h2>Clients</h2>
            </div>
            <div class="p-2">
                <a class="btn btn-primary" href="{{ route('clients.create') }}">Create New Client</a>
            </div>
        </div>
    </div>

    @if ($message = session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-hover">
        <tr>
            <th width="10%">S.no.</th>
            <th>Name</th>
            <th>Category</th>
            <th>Location</th>
            <th width="20%">Actions</th>
        </tr>
        <?php $i = 0; ?>
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
    </table>
  
@endsection