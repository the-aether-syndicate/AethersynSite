@extends('layouts.grids.3-9')
@section('title', 'Join us')
@section('content_header')
<h1>Join us for a fleet!</h1>
@stop
@section('left')

<div class="box box-primary box-solid">
    <div class="box-header">
        <h3>Role Test</h3>
    </div>
    <div class="box-body">
        @php
        use App\Models\Auth\Role;
        use App\Models\Doctrines\Fitting;
            $roles = Role::all();
            $fits = Fitting::all();
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
                    <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            </select>
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
                    <option value="{{$role->name}}">{{$role->name}}</option>
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
                    <option value="{{$role->name}}">{{$role->name}}</option>
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
                    <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" value="Submit">

        </form>
        <form method="GET" action="/role/delete">
            @csrf

            Delete Role:<br>
            <select name="name">
                @foreach($roles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" value="Submit">

        </form>
    </div>
</div>
@stop
@section('right')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>Role Test</h3>
        </div>
        <div class="box-body">
            <table id='rolelist' class="table table-hover" style="vertical-align: top">
                <thead>
                <tr>

                    <th>Role Name</th>
                    <th>Description</th>

                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <th>{{$role->name}}</th>
                        <th>{{$role->description}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop