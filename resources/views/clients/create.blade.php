@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Client Create</span>
            <a class="btn btn-sm btn-primary" href="{{route('clients')}}">Clients</a>
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
                    <form action="{{ route('clients.store') }}" method="POST">
                      @csrf
                      <div class="form-group mt-3">
                          <label class="mb-1" for="name">Name</label>
                          <input type="text" class="form-control" name="name"/>
                      </div>
                      <div class="form-group mt-3">
                        <label class="mb-2" for="category">Category</label>
                        <select class="form-control form-select" name="category" aria-label="Default select example">
                            <option value="INDIVIDUAL">Individual</option>
                            <option value="AOP">AOP</option>
                            <option value="COMPANY">Company</option>
                        </select> 
                      </div>
                      <button type="submit" class="btn btn-sm btn-primary mt-3">Submit</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

