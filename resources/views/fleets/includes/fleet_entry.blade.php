<tr>
    <td><img src='https://imageserver.eveonline.com/Character/{{ $fleet->getfc()->id }}_32.jpg' height='24' /></td>
    <td>{{$fleet->getfc()->name}}</td>
    <td>{{$fleet->created_at}}</td>
    <td>
        @if($fleet->active)
            @if($fleet->getfc()->id == auth()->user()->id)
                <a href="{{route('fleet.end', ['fleetid' => $fleet->id])}}" class="btn btn-danger">End Fleet </a>

                <a href="{{route('fleet.view', ['fleetid' => $fleet->id])}}" class="btn btn-success">View</a>

            @else
                @switch($fleet->hasMember(auth()->user()->id))
                    @case(0)
                    <a href="{{route('fleet.join', ['fleetid' => $fleet->id])}}" class="btn btn-success">Join Fleet</a>
                    @break
                    @case(1)
                    <a href="{{route('fleet.leave', ['fleetid' => $fleet->id])}}" class="btn btn-danger">Leave Fleet</a>
                    @break
                    @case(2)
                    <a href="{{route('fleet.rejoin', ['fleetid' => $fleet->id])}}" class="btn btn-success">Rejoin Fleet</a>
                    @break
                @endswitch
            @endif
        @else
            @if($fleet->complete && auth()->user()->hasRole('Fleet Commander'))
                <a href="{{route('fleet.view', ['fleetid' => $fleet->id])}}" class="btn btn-success">View</a>
            @endif
        @endif
    </td>
</tr>
@section('modals')

@stop