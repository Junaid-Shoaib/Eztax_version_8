@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Notices</span>
            <a class="btn btn-sm btn-primary" href="{{route('notices.create')}}">Create Notice</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12 border border-1 rounded-pill p-3 mt-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-select" id="filterClient">
                                <option value="">All Clients</option>
                                @foreach ($clients as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterYear">
                                <option value="">All Tax Years</option>
                                @foreach ($years as $year)
                                    <option value="{{$year->tax_year}}">{{$year->tax_year}}</opt>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterOffice">
                                <option value="">All Tax Offices</option>
                                <option value='LTO'>LTO</option>
                                <option value='RTO'>RTO</option>
                                <option value='CTO'>CTO</option>
                                <option value='CIR(A)'>CIR(A)</option>
                                <option value='ATIR'>ATIR</option>
                                <option value='High Court'>High Court</option>
                                <option value='Supreme Court'>Supreme Court</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">All</option>
                                <option value='0'>Pending</option>
                                <option value='1'>Complete</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 mt-5">
                    <table class="table table-bordered" id="userTable">
                        <thead>
                            <tr>
                               <th>S.no.</th>
                                <th>Client</th>
                                <th>Tax Year</th>
                                <th>Tax Office</th>
                                <th>Receiving Date</th>
                                <th>Status</th>
                                <th>Action</th>
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
            url: "{{ route('notices') }}",
            data: function(d) {
                d.client_id = $('#filterClient').val();
                d.year = $('#filterYear').val();
                d.office = $('#filterOffice').val();
                d.status = $('#filterStatus').val();
            }
        },
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'client',
                name: 'client'
            },
            {
                data: 'tax_year',
                name: 'tax_year'
            },
            {
                data: 'tax_office',
                name: 'tax_office'
            },
            {
                data: 'receiving_date',
                name: 'receiving_date'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });

    $('#filterClient, #filterYear, #filterOffice, #filterStatus').on('change', function() {
        table.draw();
    });
});
</script>
@endpush