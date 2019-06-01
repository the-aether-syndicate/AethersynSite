@extends('layouts.grids.12')
@section('title', 'Join us')
@section('content_header')
<h3>Edit Page</h3>
@stop
@section('full')
    <form method="POST" action="/postpage">
        @csrf
        <h4>Title</h4>
        <input type="text" name="ptitle" value="{{$ptitle}}" style="background-color: #222d32;color:#fff;">
        <input type="submit" value="Submit" class="btn btn-md pull-right btn-success">
        <br>
        <h5>Body</h5>
        <textarea rows="50"cols="150" name="pagecontent" value="" style="background-color: #222d32;color:#fff;">{{$pagecontent}}</textarea>
        <br>


    </form>
@stop