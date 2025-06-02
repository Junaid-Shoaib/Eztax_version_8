@extends('layouts.app')

@section('content')

<div class="card m-4">
  <div class="card-header">
    <h4>Create Notice</h4>
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
    <form method="post" action="{{ route('notices.store') }}" class="prevent-multi" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="client_id">Client:</label>
          <select class="form-select" name="client_id" style="width:300px;">
              <option value=''>Select client</option>
              @foreach (App\Models\Client::all() as $client)
              <option value="{{$client->id}}">{{$client->name}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
            <label for="tax_authority">Tax Authority</label>
            <select class="form-select" name="tax_authority" style="width:300px;">
              <option value=''>Select Tax Authority</option>
              <option value='FBR'>FBR</option>
              <option value='PRA'>PRA</option>
              <option value='SRB'>SRB</option>
              <option value='KPKRA'>KPKRA</option>
              <option value='BRA'>BRA</option>
              <option value='AJKRA'>AJKRA</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tax_office">Tax Office</label>
            <select class="form-select" name="tax_office" style="width:300px;">
              <option value=''>Select Tax Office</option>
              <option value='LTO'>LTO</option>
              <option value='RTO'>RTO</option>
              <option value='CIR(A)'>CIR(A)</option>
              <option value='ATIR'>ATIR</option>
              <option value='High Court'>High Court</option>
              <option value='Supreme Court'>Supreme Court</option>
            </select>
        </div>
        <div class="form-group">
            <label for="notice_heading">Notice Heading</label>
            <input type="text" class="form-control" name="notice_heading"/>
        </div>
        <div class="form-group">
            <label for="commissioner">Commissioner</label>
            <input type="text" class="form-control" name="commissioner"/>
        </div>
        <div class="form-group">
            <label for="tax_year">Tax Year</label>
            <input type="number" class="form-control" name="tax_year" placeholder="e.g. 2025"/>
        </div>
        <div class="form-group">
            <label for="receiving_date">Receiving Date</label>
            <input type="date" class="form-control" name="receiving_date"/>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" name="due_date"/>
        </div>
        <div class="form-group">
            <label for="hearing_date">Hearing Date</label>
            <input type="date" class="form-control" name="hearing_date"/>
        </div>
        <div class="form-group">
          <label for="notice">Notice:</label>
          <input type="file" class="form-control" name="notice">
        </div>

        <button type="submit" class="btn btn-secondary m-2 prevent-multi-submit">Add Notice</button>
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