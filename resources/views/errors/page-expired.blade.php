@extends('crudbooster::admin_template')
@section('content')

<div class=”title m-b-md”>
    <h1 class="text-center">The ordering period has expired, please try again later.</h1>
    
</div>
<div class="text-center">
    <img src="{{asset('img/stop-order.gif')}}" alt="Warning" class="text-center" width="300" height="300">
</div>

@endsection