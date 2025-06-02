@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Salary Case') }}</div>

                <div class="card-body">
                <form method="GET" action="/" name="form2">
                    @csrf
                    <input type="text" name="salary" id="salary" class="form-control" placeholder="Enter annual salary here"/>
                    <button class="btn btn-primary" type="submit" id='sub'>Calculate Tax</button>
                    <input type="text" name="tax" id="tax" class="form-control"/>
                </form>                    
                </div>
            </div>
        </div>
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

    $("#sub").click(function(e) {
            e.preventDefault();
            var sal = $('#salary').val()

            fetch('/getSalary', {
                method: 'POST',
                headers: {
                  "X-CSRF-TOKEN":"{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    'salary': sal,
                })
            })
            .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    // console.log(data);
                    $('#tax').val(data);
                })            

    });
});
</script>
@endsection