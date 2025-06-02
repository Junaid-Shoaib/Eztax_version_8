@extends('layouts.app')

@section('content')
  
<div class="card m-4">
  <div class="card-header">
    <h4>Edit Notice</h4>
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
    <form action="{{ route('notices.update', $notice->id) }}" method="POST" class="prevent-multi" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="client_id">Client</label>
            <input type="text" class="form-control" name="client_id" value="{{ $notice->client_id }}"/>
        </div>
        <div class="form-group">
            <label for="tax_authority">Tax Authority</label>
            <input type="text" class="form-control" name="tax_authority" value="{{ $notice->tax_authority }}"/>
        </div>
        <div class="form-group">
            <label for="tax_office">Tax Office</label>
            <input type="text" class="form-control" name="tax_office" value="{{ $notice->tax_office }}"/>
        </div>
        <div class="form-group">
            <label for="notice_heading">Notice Heading</label>
            <input type="text" class="form-control" name="notice_heading" value="{{ $notice->notice_heading }}"/>
        </div>
        <div class="form-group">
            <label for="tax_year">Tax Year</label>
            <input type="text" class="form-control" name="tax_year" value="{{ $notice->tax_year }}"/>
        </div>
        <div class="form-group">
            <label for="receiving_date">Receiving Date</label>
            <input type="text" class="form-control" name="receiving_date" value="{{ $notice->receiving_date }}"/>
        </div>

        <div class="form-group">
          <label for="reply">Reply:</label>
          <input type="file" class="form-control" name="reply">
        </div>

        <div class="form-group">
          <label for="order">Order:</label>
          <input type="file" class="form-control" name="order">
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