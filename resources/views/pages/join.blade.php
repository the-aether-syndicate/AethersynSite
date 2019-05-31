@extends('layouts.grids.12')
@section('title', 'Join us')
@section('content_header')
    <h1>Join us for a fleet!</h1>
@stop
@section('full')
    In game public channel: Triglav Defense<br>
    <a href="https://discord.gg/ZH8jvj4">Discord</a>
    Logged in as: {{auth()->user()}}
@stop