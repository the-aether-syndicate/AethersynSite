@extends('layouts.grids.12')
@section('title', 'Modular Page')
@section('content_header')
    @if(auth()->user()->hasRole('editor'))
        <a href="{{route('pages.edit',['id' => $id])}}">
    @endif
    <h3>{{$ptitle}}</h3>
    @if(auth()->user()->hasRole('editor'))
        </a>
    @endif
    Created on:{{$created}}
@stop
@section('full')
    {{$pagecontent}}
@stop