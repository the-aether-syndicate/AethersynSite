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
                    <button type="button" class="btn btn-xs btn-box-tool" id="addFitting" data-toggle="modal" data-target="#addFitModal" data-placement="top" title="Add a new fitting">
                        <span class="fa fa-plus-square"></span>
                    </button>
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

@stop
