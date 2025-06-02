@extends('layouts.app')

@section('content')

<div class="card m-4">
  <div class="card-header">
    <h4>Create Client</h4>
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
    <form method="post" action="{{ route('clients.store') }}" class="prevent-multi">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name"/>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" name="category"/>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" name="location"/>
        </div>
        <button type="submit" class="btn btn-secondary m-2 prevent-multi-submit">Add Client</button>
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