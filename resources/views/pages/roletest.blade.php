@extends('layouts.grids.3-9')
@section('title', 'Join us')
@section('content_header')
<h1>Join us for a fleet!</h1>
@stop
@section('left')

<div class="box box-primary box-solid">
    <div class="box-header">
        <h3>Role Test</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-xs btn-box-tool" id="addFitting" data-toggle="modal" data-target="#addFitModal" data-placement="top" title="Add a new fitting">
                <span class="fa fa-plus-square"></span>
            </button>
        </div>
    </div>
    <div class="box-body">
        @php
        use App\Models\Auth\Role;
            $roles = Role::all()->map(function($role)
            {return $role->name;
            });
        @endphp
        <form method="POST" action="/role/add">
            @csrf
            Role name:<br>
            <input type="text" name="name">
            <br>
            Description:<br>
            <input type="text" name="description">
            <br>
            <input type="submit" value="Submit">

        </form>

        <form method="POST" action="/role/give">
            @csrf
            <input type="hidden" name="user" value="{{auth()->user()->name}}">
            <br>
            Add Role:<br>
            <select name="role">
                @foreach($roles as $role)
                    <option value="{{$role}}">{{$role}}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" value="Submit">

        </form>
        <form method="POST" action="/role/take">
            @csrf
            <input type="hidden" name="user" value="{{auth()->user()->name}}">
            <br>
            Take Role:<br>
            <select name="role">
                @foreach($roles as $role)
                    <option value="{{$role}}">{{$role}}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" value="Submit">

        </form>
        <form method="POST" action="/role/delete">
            @csrf

            Delete Role:<br>
            <select name="name">
                @foreach($roles as $role)
                    <option value="{{$role}}">{{$role}}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" value="Submit">

        </form>
    </div>
</div>
@stop
@section('right')
    @php
    $userroles = auth()->user()->roles()->get();
    @endphp
    Logged in as: {{auth()->user()->name}}<br>
    Roles:<br>
    @foreach($userroles as $role)
        {{$role->name}}<br>
    @endforeach
@stop