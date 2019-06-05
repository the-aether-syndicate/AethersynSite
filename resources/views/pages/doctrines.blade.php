@extends('layouts.grids.4-4-4')
@section('title', 'Doctrine')
@section('content_header')
<h1>TriglavDefense Doctrine</h1>
@stop
@section('left')
<div class="box box-primary box-solid">
    <div class="box-header">
        <h3>Fittings</h3>
        @if(auth()->user())
        @if(auth()->user()->hasRole('Doctrine Edit'))
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-xs btn-box-tool" id="addFitting" data-toggle="modal" data-target="#addFitModal" data-placement="top" title="Add a new fitting">
                <span class="fa fa-plus-square"></span>
            </button>
        </div>
        @endif
            @endif
    </div>
    <div class="box-body">
        <table id='fitlist' class="table table-hover" data-id="{{$doctrineid}}"style="vertical-align: top">
            <thead>
            <tr>
                <th></th>
                <th>Ship</th>
                <th>Fit Name</th>
                <th class="pull-right">Option</th>
            </tr>

            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="addFitModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Are you sure?</h4>
            </div>
            <form role="form" action="{{ route('doctrine.saveFitting', ['id' => 1]) }}" method="post">
                <input type="hidden" id="fitSelection" name="fitSelection" value="0">
                <div class="modal-body">
                    <p>Cut and Paste EFT fitting in the box below</p>
                    {{ csrf_field() }}
                    <textarea name="eftfitting" id="eftfitting" rows="15" style="width: 100%"></textarea>
                </div>
                <div class="modal-footer">
                    <div class="btn-group pull-right" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" id="savefitting" value="Submit Fitting" />
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
@section('center')
    <div class="box box-primary box-solid" id="fitting-box">
        <div class="box-header"><h3 class="box-title" id='middle-header'></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-xs btn-box-tool" id="deleteFit" data-placement="top" title="Delete fitting">
                    <span class="fa fa-minus-square"></span>
                </button>
            </div>
        </div>
        <input type="hidden" id="fittingId" value=""\>
        <div class="box-body">
            <div id="fitting-window">
                <table class="table table-condensed" id="lowSlots">
                    <thead>
                    <tr>
                        <th>Low Slot Module</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <table class="table table-condensed" id="midSlots">
                    <thead>
                    <tr>
                        <th>Mid Slot Module</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <table class="table table-condensed" id="highSlots">
                    <thead>
                    <tr>
                        <th>High Slot Module</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <table class="table table-condensed" id="rigs">
                    <thead>
                    <tr>
                        <th>Rigs</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    <table class="table table-condensed" id="subSlots">
                        <thead>
                        <tr>
                            <th>Subsystems</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </table>
                <table id="drones" class="table table-condensed">
                    <thead>
                    <tr>
                        <th class="col-md-10">Drone Bay</th>
                        <th class="col-md-2">Number</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('right')
    <div class="box box-primary box-solid" id='eftexport'>
        <div class="box-header">
            <h3 class="box-title">EFT Fitting</h3>
        </div>
        <div class="box-body">
            <textarea name="showeft" id="showeft" rows="30" style="width: 100%" onclick="this.focus();this.select()" readonly="readonly"></textarea>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        var activeFit;
        $('#fitting-box').hide();
        $('#skills-box').hide();
        $('#eftexport').hide();
        $('#showeft').val('');



        $('#fitlist').ready(function () {
            id = $('#fitlist').attr('data-id');
            $.ajax({
                headers: function () {
                },
                url: "/doctrine/get/" + id,
                type: "GET",
                dataType: 'json',
                timeout: 10000
            }).done(function (result) {
                if (result) {
                    $('#fitlist').find("tbody").empty();
                    for (var fitting in result) {

                        row = "<tr id=\'fit"+ result[fitting].id +"\'><td><img src='https://image.eveonline.com/Type/" + result[fitting].shipImg + "_32.png' height='24' /></td>";
                        row = row + "<td>" + result[fitting].shipType + "</td>";
                        row = row + "<td>" + result[fitting].name + "</td>";
                        row = row + "<td><button type='button' id='viewfit' class='btn btn-xs btn-success pull-right' data-id='" + result[fitting].id + "' data-toggle='tooltip' data-placement='top' title='View Fitting'>";
                        row = row + "<span class='fa fa-eye text-white'></span></button></td></tr>";
                        $('#fitlist').find("tbody").append(row);
                    }
                }
            });
        });
        $('#fitlist').on('click', '#viewfit', function () {
            $('#highSlots, #midSlots, #lowSlots, #rigs, #cargo, #drones, #subSlots')
                .find('tbody')
                .empty();
            $('#fittingId').text($(this).data('id'));
            activeFit = $(this).data('id');
            uri = "['id' => " + $(this).data('id') +"]";
            $.ajax({
                headers: function () {
                },
                url: "/doctrine/fit/"+$(this).data('id'),
                type: "GET",
                dataType: 'json',
                timeout: 10000
            }).done( function (result) {
                $('#highSlots, #midSlots, #lowSlots, #rigs, #cargo, #drones, #subSlots')
                    .find('tbody')
                    .empty();
                $('#showeft').val('');
                $('#fitting-box').show();
                fillFittingWindow(result);
            });
            $('#fitting-box').ready(function () {

                $('#fitting-box').on('click', '#deleteFit', function() {
                    tr = $('#fit');
                    $.ajax({
                        headers: function () {
                        },
                        url: "/fitting/delete/"+activeFit,
                        type: "GET",
                        dataType: 'json',
                        timeout: 10000
                    }).done( function (result) {
                        setTimeout(function(){
                            location = location;
                        });


                    });
                });
            });
            /*$.ajax({
                headers: function () {
                },
                url: "/fitting/getskillsbyfitid/"+$(this).data('id'),
                type: "GET",
                dataType: 'json',
                timeout: 10000
            }).done( function (result) {
                if (result) {
                    skills_informations = result;
                    $('#skills-box').show();
                    $('#skillbody').empty();
                    if ($('#characterSpinner option').size() === 0) {
                        for (var toons in result.characters) {
                            $('#characterSpinner').append('<option value="'+result.characters[toons].id+'">'+result.characters[toons].name+'</option>');
                        }
                    }
                    fillSkills(result);
                }
            });*/
        });

        function fillFittingWindow (result) {
            if (result) {
                $('#fitting-window').show();
                $('#middle-header').text(result.shipname + ', ' + result.fitname);
                $('#showeft').val(result.eft);
                $('#eftexport').show();
                for (var slot in result) {
                    if (slot.indexOf('HiSlot') >= 0)
                        $('#highSlots').find('tbody').append(
                            "<tr><td><img src='https://image.eveonline.com/Type/" + result[slot].id + "_32.png' height='24' /> " + result[slot].name + "</td></tr>");
                    if (slot.indexOf('MedSlot') >= 0)
                        $('#midSlots').find('tbody').append(
                            "<tr><td><img src='https://image.eveonline.com/Type/" + result[slot].id + "_32.png' height='24' /> " + result[slot].name + "</td></tr>");
                    if (slot.indexOf('LoSlot') >= 0)
                        $('#lowSlots').find('tbody').append(
                            "<tr><td><img src='https://image.eveonline.com/Type/" + result[slot].id + "_32.png' height='24' /> " + result[slot].name + "</td></tr>");
                    if (slot.indexOf('RigSlot') >= 0)
                        $('#rigs').find('tbody').append(
                            "<tr><td><img src='https://image.eveonline.com/Type/" + result[slot].id + "_32.png' height='24' /> " + result[slot].name + "</td></tr>");
                    if (slot.indexOf('SubSlot') >= 0)
                        $('#subSlots').find('tbody').append(
                            "<tr><td><img src='https://image.eveonline.com/Type/" + result[slot].id + "_32.png' height='24' /> " + result[slot].name + "</td></tr>");
                    if (slot.indexOf('dronebay') >= 0) {
                        for (var item in result[slot])
                            $('#drones').find('tbody').append(
                                "<tr><td><img src='https://image.eveonline.com/Type/" + item + "_32.png' height='24' /> " + result[slot][item].name + "</td><td>" + result[slot][item].qty + "</td></tr>");
                    }
                }
            }
        }
    </script>
@endpush