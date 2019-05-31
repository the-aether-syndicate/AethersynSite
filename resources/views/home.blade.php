@extends('layouts.grids.12')
@section('title', 'Home')
@section('content_header')
    <h1>Welcome to TriglavDefense!</h1>
@stop
@section('full')
    <div>Bear with us, the site is under construction!</div>
    {{ auth()->user() }}
@stop
