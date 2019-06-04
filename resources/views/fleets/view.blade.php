@extends('layouts.grids.4-8')
@section('title', 'Home')
@section('content_header')
    <h1>TriglavDefense Fleets</h1>
@stop
@section('left')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>{{$fleet->fleet_name}}</h3>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>FC</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Duration</th>

                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src='https://imageserver.eveonline.com/Character/{{ $fleet->getfc()->id }}_32.jpg' height='24' /></td>
                        <td>{{$fleet->getfc()->name}}</td>
                        <td>{{$fleet->created_at}}</td>
                        @if($fleet->complete)
                            <td>{{$fleet->ended_at}}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{$fleet->duration()}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>Participants</h3>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>Member</th>
                    <th>Duration</th>
                    @if($fleet->loot)
                        <th>Payout</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if($fleet->participants)
                    @foreach($fleet->participants as $user)
                        <tr>
                        <td><img src='https://imageserver.eveonline.com/Character/{{ $user->id }}_32.jpg' height='24' /></td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->punches()->where('fleet_id', $fleet->id)->first()->duration()}} {{sprintf("%.2f%%", ($user->punches()->where('fleet_id', $fleet->id)->first()->seconds()/$fleet->seconds()) * 100)}}</td>
                        @if($fleet->loot)
                            <td>{{number_format(($fleet->loot['totals']['buy'] * (1/$fleet->participants()->count())) * ($user->punches()->where('fleet_id', $fleet->id)->first()->seconds()/$fleet->seconds()))}}</td>
                        @endif
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>
    </div>
@stop
@section('right')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3>Loot</h3>
            @if($fleet->loot == null)
                <button type="button" class="btn btn-xs btn-box-tool" id="addLoot" data-toggle="modal" data-target="#addLootModal" data-placement="top" title="Add a new fitting">
                    <span class="fa fa-plus-square"></span>
                </button>
            @endif
        </div>
        <div class="box-body">
            <table class="table" id='lootlist'>
                <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Jita Buy</th>
                    <th>Total</th>

                </tr>
                </thead>
                <tbody>
                @if($fleet->loot)
                    @foreach($fleet->loot['items'] as $loot)
                    <tr>
                        <td></td>
                        <td>{{$loot['name']}}</td>
                        <td>{{$loot['quantity']}}</td>
                        <td>{{number_format($loot['prices']['buy']['max'])}}</td>
                        <td>{{number_format($loot['prices']['buy']['max'] * $loot['quantity'])}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td>Total:</td>
                        <td></td>
                        <td></td>
                        <td>{{number_format($fleet->loot['totals']['buy'])}}</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="addLootModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Are you sure?</h4>
                </div>
                <form role="form" action="{{ route('fleet.saveLoot', ['id' => $fleet->id]) }}" method="post">
                    <div class="modal-body">
                        <p>Cut and Paste Loot below</p>
                        {{ csrf_field() }}
                        <textarea name="loottext" id="loottext" rows="15" style="width: 100%"></textarea>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group pull-right" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-primary" id="saveloot" value="Submit Loot" />
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop
@push('js')
    <script type="text/javascript">
        let lootlist = $('#lootlist');



    </script>
@endpush