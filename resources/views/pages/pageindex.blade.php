@extends('layouts.grids.12')
@section('title', 'Pages')
@section('content_header')
    <h3>Page List</h3>
@stop
@section('full')
    @php
    use App\Models\Page\Page;

    $pages = Page::all();
    @endphp
    @foreach($pages as $page)
        <a href="{{route('pages', ['id'=>$page->id])}}"><h4>{{$page->title}}</h4></a><br>
    @endforeach
@stop