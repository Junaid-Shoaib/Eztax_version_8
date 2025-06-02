@extends('layouts.app')

@section('content')
  
<div class="card m-4">
  <div class="card-header">
    <h4>Edit Client</h4>
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
    @endif
    <form action="{{ route('clients.update', $client->id) }}" method="POST" class="prevent-multi">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $client->name }}"/>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" name="category" value="{{ $client->category }}"/>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" name="location" value="{{ $client->location }}"/>
        </div>
        <button type="submit" class="btn btn-secondary m-2 prevent-multi-submit">Submit</button>
    </form>
  </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    $(document).on("keydown", ":input:not(textarea):not(:submit)", function(event) {
    if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });
    $('.prevent-multi').on('submit', function(){
        $('.prevent-multi-submit').attr('disabled','true');
        return true;
    });
});
</script>
@endsection