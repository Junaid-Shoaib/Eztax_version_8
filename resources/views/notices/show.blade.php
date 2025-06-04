@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>View Notice</span>
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="client_id">Client</label>
                                        <select class="form-select" disabled name="client_id" id="filterClient">
                                            @foreach($clients as $client)
                                                <option value="{{$client->id}}" {{ $client->id == $notice->client_id ? "selected" : ''}}>{{$client->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_authority">Tax Authority</label>
                                        <select class="form-contro0l form-select" disabled name="tax_authority">
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
                                            <option value='Income Tax Tribunal' {{ $notice->tax_authority == 'Income Tax Tribunal' ? 'selected' : '' }}>Income Tax Tribunal</option>
                                            
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_office">Tax Office</label>
                                        <select class="form-control form-select" disabled name="tax_office">
                                            <option value=''>Select Tax Office</option>
                                            <option value='LTO' {{ $notice->tax_office == 'LTO' ? 'selected' : ''}}>LTO</option>
                                            <option value='RTO' {{ $notice->tax_office == 'RTO' ? 'selected' : ''}}>RTO</option>
                                            <option value='CTO' {{ $notice->tax_office == 'CTO' ? 'selected' : ''}}>CTO</option>
                                            <option value='MTO' {{ $notice->tax_office == 'MTO' ? 'selected' : ''}}>MTO</option>
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
                                        <input type="text" class="form-control" disabled name="notice_heading"
                                            value="{{ $notice->notice_heading }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="notice_heading">Notice Commissioner</label>
                                        <input type="text" class="form-control" disabled name="commissioner"
                                            value="{{ $notice->commissioner }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_year">Tax Year</label>
                                        <input type="text" class="form-control" disabled name="tax_year"
                                            value="{{ $notice->tax_year }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="receiving_date">Receiving Date</label>
                                        <input type="date" class="form-control" disabled name="receiving_date"
                                            value="{{ $notice->receiving_date }}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="due_date">Due Date</label>
                                        <input type="date" class="form-control" disabled name="due_date"
                                            value="{{ $notice->due_date }}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="hearing_date">Hearing Date</label>
                                        <input type="date" class="form-control" disabled name="hearing_date"
                                            value="{{ $notice->hearing_date }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="reply">Notice: </label>
                                        @if ($notice->notice_path)
                                            @php
                                                $filePath = 'storage/' . $notice->notice_path;
                                                
                                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                            @endphp

                                            @if (in_array(strtolower($extension), $imageExtensions))
                                                <p><a href="{{ asset($filePath) }}" target="_blank">
                                                    <img src="{{ asset($filePath) }}" alt="{{ $notice->notice_name }}" style="height:100px; width:100px;">
                                                    </a>
                                                </p>
                                            @else
                                            <p>
                                                <a href="{{ asset($filePath) }}" target="_blank">
                                                    View File ({{ strtoupper($extension) }})
                                                </a>
                                            </p>
                                            @endif
                                        @else
                                            <p class="text-muted">No file uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="reply">Reply: </label>
                                        @if ($notice->reply_path)
                                            @php
                                                $filePath = 'storage/' . $notice->reply_path;
                                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                            @endphp

                                            @if (in_array(strtolower($extension), $imageExtensions))
                                                <p>
                                                    <a href="{{ asset($filePath) }}" target="_blank">
                                                    
                                                        <img src="{{ asset($filePath) }}" alt="{{ $notice->reply_name }}" style="height:100px; width:100px;">
                                                    </a>
                                                </p>
                                            @else
                                            <p>
                                                <a href="{{ asset($filePath) }}" target="_blank">
                                                    View File ({{ strtoupper($extension) }})
                                                </a>
                                            </p>
                                            @endif
                                        @else
                                            <p class="text-muted">No file uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="order">Order: </label>
                                              @if ($notice->order_path)
                                            @php
                                                $filePath = 'storage/' . $notice->order_path;
                                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                            @endphp

                                            @if (in_array(strtolower($extension), $imageExtensions))
                                            <p>    
                                                <a href="{{ asset($filePath) }}" target="_blank">
                                                    <img src="{{ asset($filePath) }}" alt="{{ $notice->order_name }}" style="height:100px; width:100px;">
                                                </a>
                                            </p>
                                            @else
                                            <p>
                                                <a href="{{ asset($filePath) }}" target="_blank">
                                                        View File ({{ strtoupper($extension) }})
                                                </a>
                                            </p>    
                                            @endif
                                        @else
                                            <p class="text-muted">No file uploaded</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            

                            
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection