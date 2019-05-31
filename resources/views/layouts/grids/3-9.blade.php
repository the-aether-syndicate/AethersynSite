@extends('adminlte::page')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @yield('left')
        </div>
        <div class="col-md-9">
            @yield('right')
        </div>
    </div>
@stop