@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Notice Create</span>
                <a class="btn btn-sm btn-primary" href="{{route('notices')}}">Notices</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('notices.store') }}" class="prevent-multi"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="client_id">Client:</label>
                                        <select class="form-control form-select" name="client_id">
                                            <option value=''>Select client</option>
                                            @foreach (App\Models\Client::all() as $client)
                                                <option value="{{$client->id}}">{{$client->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_authority">Tax Authority</label>
                                        <select class="form-control form-select" name="tax_authority">
                                            <option value=''>Select Tax Authority</option>
                                            <option value='FBR'>FBR</option>
                                            <option value='PRA'>PRA</option>
                                            <option value='SRB'>SRB</option>
                                            <option value='KPKRA'>KPKRA</option>
                                            <option value='BRA'>BRA</option>
                                            <option value='AJKRA'>AJKRA</option>
                                            <option value='Income Tax Tribunal'>Income Tax Tribunal</option>
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
                                            <option value='LTO'>LTO</option>
                                            <option value='RTO'>RTO</option>
                                            <option value='MTO'>MTO</option>
                                            <option value='CTO'>CTO</option>
                                            <option value='CIR(A)'>CIR(A)</option>
                                            <option value='ATIR'>ATIR</option>
                                            <option value='High Court'>High Court</option>
                                            <option value='Supreme Court'>Supreme Court</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="notice_heading">Notice Heading</label>
                                        <input type="text" class="form-control" name="notice_heading" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-group mt-3">
                                      <label for="commissioner">Commissioner</label>
                                      <input type="text" class="form-control" name="commissioner" />
                                  </div>
                                </div>  
                              <div class="col-sm-6">
                                  <div class="form-group mt-3">
                                      <label for="tax_year">Tax Year</label>
                                      <input type="number" class="form-control" name="tax_year" placeholder="e.g. 2025" />
                                  </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="receiving_date">Receiving Date</label>
                                        <input type="date" class="form-control" name="receiving_date" />
                                    </div>        
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="due_date">Due Date</label>
                                        <input type="date" class="form-control" name="due_date" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="hearing_date">Hearing Date</label>
                                        <input type="date" class="form-control" name="hearing_date" />
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group mt-3">
                                <label for="notice">Notice:</label>
                                <input type="file" class="form-control" name="notice">
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary mt-3 prevent-multi-submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("keydown", ":input:not(textarea):not(:submit)", function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            $('.prevent-multi').on('submit', function () {
                $('.prevent-multi-submit').attr('disabled', 'true');
                return true;
            });
        });
    </script>
@endsection