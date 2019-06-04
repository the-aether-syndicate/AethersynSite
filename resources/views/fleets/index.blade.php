@extends('layouts.grids.12')
@section('title', 'Home')
@section('content_header')
    <h1>TriglavDefense Fleets</h1>
@stop
@section('full')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>Active Fleets</h3>
            @if(auth()->user()->hasRole('Fleet Commander'))
                <div class="box-tools pull-right">
                    <a href="{{ route('fleet.add') }}" class="btn btn-xs btn-box-tool">
                        <span class="fa fa-plus-square"></span>
                    </a>
                </div>
            @endif
        </div>
        <div class="box-body">
    <table>
        <thead>
            <tr>
                <th></th>
                <th>FC</th>
                <th>Start Time</th>
                <th>Options</th>
            </tr>
        </thead>
        @each('fleets.includes.fleet_entry', $active, 'fleet')
    </table>

        </div>
    </div>
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>Active Fleets</h3>
            @if(auth()->user()->hasRole('Fleet Commander'))
                <div class="box-tools pull-right">
                    <a href="{{ route('fleet.add') }}" class="btn btn-xs btn-box-tool">
                        <span class="fa fa-plus-square"></span>
                    </a>
                </div>
            @endif
        </div>
        <div class="box-body">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>FC</th>
                    <th>Start Time</th>
                    <th>Options</th>
                </tr>
                </thead>
                @each('fleets.includes.fleet_entry', $completed, 'fleet')
            </table>

        </div>
    </div>

@stop
