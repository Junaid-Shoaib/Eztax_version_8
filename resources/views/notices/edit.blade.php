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

                                            <option value='Income Tax Tribunal' {{ $notice->tax_authority == 'Income Tax Tribunal' ? 'selected' : '' }}>Income Tax Tribunal</option>
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
                                            <option value='LTO' {{ $notice->tax_office == 'LTO' ? 'selected' : ''}}>LTO
                                            </option>
                                            <option value='RTO' {{ $notice->tax_office == 'RTO' ? 'selected' : ''}}>RTO
                                            </option>
                                            <option value='CTO' {{ $notice->tax_office == 'CTO' ? 'selected' : ''}}>CTO
                                            </option>
                                            <option value='MTO' {{ $notice->tax_office == 'MTO' ? 'selected' : ''}}>MTO
                                            </option>
                                            <option value='CIR(A)' {{ $notice->tax_office == 'CIR(A)' ? 'selected' : ''}}>
                                                CIR(A)</option>
                                            <option value='ATIR' {{ $notice->tax_office == 'ATIR' ? 'selected' : ''}}>ATIR
                                            </option>
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
                                <ul class="nav nav-tabs custom-tab-nav justify-content-center gap-2 mb-3" id="noticeTabs"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="reply-tab" data-bs-toggle="tab"
                                            data-bs-target="#reply" type="button" role="tab">
                                            <i class="bi bi-file-earmark-text"></i> Replies ({{ $replyCount ?? 0 }})
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#order"
                                            type="button" role="tab">
                                            <i class="bi bi-file-earmark"></i> Orders ({{ $orderCount ?? 0 }})
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="notice-tab" data-bs-toggle="tab"
                                            data-bs-target="#received" type="button" role="tab">
                                            <i class="bi bi-file-earmark-arrow-down"></i> Received
                                            ({{ $receivedCount ?? 0 }})
                                        </button>
                                    </li>
                                </ul>



                                <div class="tab-content" id="noticeTabsContent">
                                    <!-- Reply Tab -->
                                    <div class="tab-pane fade show active" id="reply" role="tabpanel"
                                        aria-labelledby="reply-tab">
                                        @if(!empty($documents['reply']) && $documents['reply']->count())
                                            @foreach($documents['reply'] as $doc)
                                                <div
                                                    class="p-3 mb-2 bg-light rounded d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $doc->name }}</strong>
                                                        <br>
                                                        <small><i class="bi bi-calendar"></i>
                                                            {{ \Carbon\Carbon::parse($doc->date)->format('d/m/Y') }}</small>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">View File</a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-warning text-center">No replies found.</div>
                                        @endif

                                        <hr>
                                        <h4> Add New Reply</h4>
                                        <br />

                                        <div class="mb-3">
                                            <label for="reply_heading" class="form-label">Reply Heading</label>
                                            <input type="text" class="form-control" name="reply_heading" id="reply_heading">
                                        </div>

                                        <div class="mb-3">
                                            <label for="reply_date" class="form-label">Reply Date</label>
                                            <input type="date" class="form-control" name="reply_date" id="reply_date"
                                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Upload Reply Document</label>
                                            <input type="file" name="reply" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Order Tab -->
                                    <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                                        @if(!empty($documents['order']) && $documents['order']->count())
                                            @foreach($documents['order'] as $doc)
                                                <div
                                                    class="p-3 mb-2 bg-light rounded d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $doc->name }}</strong>
                                                        <br>
                                                        <small><i class="bi bi-calendar"></i>
                                                            {{ \Carbon\Carbon::parse($doc->date)->format('d/m/Y') }}</small>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">View File</a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-warning text-center">No orders found.</div>
                                        @endif
                                        <hr>
                                        <h4> Add New Order</h4>
                                        <br />
                                        <div class="mb-3">
                                            <label for="order_heading" class="form-label">Order Heading</label>
                                            <input type="text" class="form-control" name="order_heading" id="order_heading">
                                        </div>

                                        <div class="mb-3">
                                            <label for="order_date" class="form-label">Order Date</label>
                                            <input type="date" class="form-control" name="order_date" id="order_date"
                                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Upload Order Document</label>
                                            <input type="file" name="order" accept="application/pdf" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Receive Tab -->
                                    <div class="tab-pane fade" id="received" role="tabpanel" aria-labelledby="received-tab">
                                        @if(!empty($documents['received']) && $documents['received']->count())
                                            @foreach($documents['received'] as $doc)
                                                <div
                                                    class="p-3 mb-2 bg-light rounded d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $doc->name }}</strong>
                                                        <br>
                                                        <small><i class="bi bi-calendar"></i>
                                                            {{ \Carbon\Carbon::parse($doc->date)->format('d/m/Y') }}</small>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">View File</a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-warning text-center">No received notices found.</div>
                                        @endif
                                        <hr>
                                        <h4> Add New Received</h4>
                                        <br />

                                        <div class="mb-3">
                                            <label for="order_heading" class="form-label">Received Heading</label>
                                            <input type="text" class="form-control" name="received_heading"
                                                id="order_heading">
                                        </div>

                                        <div class="mb-3">
                                            <label for="order_date" class="form-label">Received Date</label>
                                            <input type="date" class="form-control" name="received_date" id="order_date"
                                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Upload Received Document </label>
                                            <input type="file" name="received" 
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection