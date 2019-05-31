@extends('adminlte::page')
@section('content')
    <div class="row b">
        <div class="col-md-4">
            @yield('left')
        </div>
        <div class="col-md-4">
            @yield('center')
        </div>
        <div class="col-md-4">
            @yield('right')
        </div>
    </div>
@stop