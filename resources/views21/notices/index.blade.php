@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="m-2">
            <div class="p-2">
                <h2>Notices</h2>
            </div>
            <div class="p-2">
                <a class="btn btn-primary" href="{{ route('notices.create') }}">Create New Notice</a>

                <!-- <form method="get" action="{{ route('notices') }}">
                @csrf
                <div class="float-right btn-group">
                    <input type="text" class="form-control" name="search" value="{{$search}}"/>
                    <button class="btn btn-sm btn-primary search">Search</button>
                </div>
                </form> -->
            </div>

            <div class="container">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                </svg>
                Filter Notices

                <div class="row border border-1 rounded-pill p-3">
                    <div class="col">
                        <form method="get" action="{{ route('notices') }}" name="form1">
                        @csrf
                            <div class="form-group">
                                <label for="client">Client</label>
                                <select class="form-select" name="client" id="client" style="width:300px;">
                                <option value='0'>All Clients</option>
                                @foreach (App\Models\Client::all() as $cl)
                                <option value="{{$cl->id}}" {{ ( $cl->id == $client) ? 'selected' : '' }}>{{$cl->name}}</option>
                                @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="tax_year">Tax Year</label>
                            <select class="form-select" name="tax_year" style="width:300px;">
                            <option value=''>All Tax Years</option>
                            @foreach ($years as $year)
                            <option value="{{$year->tax_year}}">{{$year->tax_year}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="tax_office">Tax Office</label>
                            <select class="form-select" name="tax_office" style="width:300px;">
                            <option value=''>All Tax Offices</option>
                            <option value='LTO'>LTO</option>
                            <option value='RTO'>RTO</option>
                            <option value='CIR(A)'>CIR(A)</option>
                            <option value='ATIR'>ATIR</option>
                            <option value='High Court'>High Court</option>
                            <option value='Supreme Court'>Supreme Court</option>
                            </select>
                        </div>
                    </div>
                </div>
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
            <th>Client</th>
            <th>Tax Authority</th>
            <th>Receiving Date</th>
            <th width="20%">Actions</th>
        </tr>
        <?php $i = 0; ?>
        @foreach ($notices as $notice)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $notice->client_id }}</td>
            <td>{{ $notice->tax_authority }}</td>
            <td>{{ $notice->notice_path }}</td>
            <td class="d-flex justify-content-around">
                <strong>Completed:</strong>
                    @if($notice->status =='0')
                    No
                    @else
                    Yes
                    @endif
                <form method="POST" action="{{ route('notices.change', $notice->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{$notice->status}}">
                    <button class="btn btn-primary" type="submit">Change status</button>
                </form>
                <a class="btn btn-secondary" href="{{ route('notices.edit', $notice->id) }}">Edit</a>
                <form action="{{ route('notices.destroy', $notice->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
@endsection

@section('script')
<script>
$(document).ready(function() {
  $('#client').on('change', function() {
     document.forms['form1'].submit();
  });
});
</script>
@endsection