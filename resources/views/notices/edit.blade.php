@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Notice Update</span>
                <a class="btn btn-sm btn-primary" href="{{route('notices')}}">Notices</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('notices.update', [$notice->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="client_id">Client</label>
                                        <select class="form-select" name="client_id" id="filterClient">
                                            @foreach($clients as $client)
                                                <option value="{{$client->id}}" {{ $client->id == $notice->client_id ? "selected" : ''}}>{{$client->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_authority">Tax Authority</label>
                                        <select class="form-contro0l form-select" name="tax_authority">
                                            <option value=''>Select Tax Authority</option>
                                            <option value='FBR' {{ $notice->tax_authority == 'FBR' ? 'selected' : '' }}>FBR
                                            </option>
                                            <option value='PRA' {{ $notice->tax_authority == 'PRA' ? 'selected' : '' }}>PRA
                                            </option>
                                            <option value='SRB' {{ $notice->tax_authority == 'SRB' ? 'selected' : '' }}>SRB
                                            </option>
                                            <option value='KPKRA' {{ $notice->tax_authority == 'KPKRA' ? 'selected' : '' }}>
                                                KPKRA</option>
                                            <option value='BRA' {{ $notice->tax_authority == 'BRA' ? 'selected' : '' }}>BRA
                                            </option>
                                            <option value='AJKRA' {{ $notice->tax_authority == 'AJKRA' ? 'selected' : '' }}>
                                                AJKRA</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_office">Tax Office</label>
                                        <select class="form-control form-select" name="tax_office">
                                            <option value=''>Select Tax Office</option>
                                            <option value='LTO' {{ $notice->tax_office == 'LTO' ? 'selected' : ''}}>LTO</option>
                                            <option value='RTO' {{ $notice->tax_office == 'RTO' ? 'selected' : ''}}>RTO</option>
                                            <option value='CTO' {{ $notice->tax_office == 'CTO' ? 'selected' : ''}}>CTO</option>
                                            <option value='CIR(A)' {{ $notice->tax_office == 'CIR(A)' ? 'selected' : ''}}>CIR(A)</option>
                                            <option value='ATIR' {{ $notice->tax_office == 'ATIR' ? 'selected' : ''}}>ATIR</option>
                                            <option value='High Court' {{ $notice->tax_office == 'High Court' ? 'selected' : ''}}>High Court</option>
                                            <option value='Supreme Court' {{ $notice->tax_office == 'Supreme Court' ? 'selected' : ''}}>Supreme Court</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="notice_heading">Notice Heading</label>
                                        <input type="text" class="form-control" name="notice_heading"
                                            value="{{ $notice->notice_heading }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="notice_heading">Notice Commissioner</label>
                                        <input type="text" class="form-control" name="commissioner"
                                            value="{{ $notice->commissioner }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_year">Tax Year</label>
                                        <input type="text" class="form-control" name="tax_year"
                                            value="{{ $notice->tax_year }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="receiving_date">Receiving Date</label>
                                        <input type="date" class="form-control" name="receiving_date"
                                            value="{{ $notice->receiving_date }}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="due_date">Due Date</label>
                                        <input type="date" class="form-control" name="due_date"
                                            value="{{ $notice->due_date }}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="hearing_date">Hearing Date</label>
                                        <input type="date" class="form-control" name="hearing_date"
                                            value="{{ $notice->hearing_date }}" />
                                    </div>
                                </div>
                            </div>





                            <div class="form-group mt-3">
                                <label for="reply">Reply:</label>
                                <input type="file" class="form-control" name="reply">
                                @if($notice->reply_path)
                                    <a
                                        href="{{ route('file.download', [\Illuminate\Support\Str::after($notice->reply_path, '/')]) }}">
                                        <img src="{{ asset('storage/' . $notice->reply_path) }}" alt="{{ $notice->reply_name }}"
                                            style="height:100px; width:100px">
                                    </a>
                                @endif
                            </div>

                            <div class="form-group mt-3">
                                <label for="order">Order:</label>
                                <input type="file" class="form-control" name="order">
                                @if($notice->order_path)
                                    <a
                                        href="{{ route('file.download', [\Illuminate\Support\Str::after($notice->reply_path, '/')]) }}">
                                        <img src="{{ asset('storage/' . $notice->order_path) }}" alt="{{ $notice->order_name }}"
                                            style="height:100px; width:100px">
                                    </a>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection