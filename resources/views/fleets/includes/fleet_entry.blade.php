<tr>
    <td><img src='https://imageserver.eveonline.com/Character/{{ $fleet->getfc()->id }}_32.jpg' height='24' /></td>
    <td>{{$fleet->getfc()->name}}</td>
    <td>{{$fleet->created_at}}</td>
    <td>
        @if($fleet->active)
        @if($fleet->getfc()->id == auth()->user()->id)
        <a href="{{route('fleet.end', ['fleetid' => $fleet->id])}}" class="btn btn-danger">End Fleet </a>
        @else
            @if($fleet->punches()->where('user_id', auth()->user()->id))
                <a href="{{route('fleet.leave', ['fleetid' => $fleet->id])}}" class="btn btn-danger">Leave Fleet </a>
                @else
            <a href="{{route('fleet.join', ['fleetid' => $fleet->id])}}" class="btn btn-success">Join Fleet </a>
                @endif
            @endif
        @endif
        @if($fleet->complete)
                <a href="{{route('fleet.leave', ['fleetid' => $fleet->id])}}" class="btn btn-success">Loot</a>
        @endif
    </td>
</tr>