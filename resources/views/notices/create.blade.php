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
                                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_authority">Tax Authority</label>
                                        <select class="form-control form-select" name="tax_authority">
                                            <option value=''>Select Tax Authority</option>
                                            @foreach (['FBR', 'PRA', 'SRB', 'KPKRA', 'BRA', 'AJKRA', 'Income Tax Tribunal'] as $authority)
                                                <option value="{{ $authority }}" {{ old('tax_authority') == $authority ? 'selected' : '' }}>
                                                    {{ $authority }}
                                                </option>
                                            @endforeach
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
                                            @foreach (['LTO', 'RTO', 'MTO', 'CTO', 'CIR(A)', 'ATIR', 'High Court', 'Supreme Court'] as $office)
                                                <option value="{{ $office }}" {{ old('tax_office') == $office ? 'selected' : '' }}>
                                                    {{ $office }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="notice_heading">Notice Heading</label>
                                        <input type="text" class="form-control" name="notice_heading"
                                            value="{{ old('notice_heading') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="commissioner">Commissioner</label>
                                        <input type="text" class="form-control" name="commissioner"
                                            value="{{ old('commissioner') }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-3">
                                        <label for="tax_year">Tax Year</label>
                                        <input type="number" class="form-control" name="tax_year" placeholder="e.g. 2025"
                                            value="{{ old('tax_year') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="receiving_date">Receiving Date</label>
                                        <input type="date" class="form-control" name="receiving_date"
                                            value="{{ old('receiving_date') }}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="due_date">Due Date</label>
                                        <input type="date" class="form-control" name="due_date"
                                            value="{{ old('due_date') }}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mt-3">
                                        <label for="hearing_date">Hearing Date</label>
                                        <input type="date" class="form-control" name="hearing_date"
                                            value="{{ old('hearing_date') }}" />
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