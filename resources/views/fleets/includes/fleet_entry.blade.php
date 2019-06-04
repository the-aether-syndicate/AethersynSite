<tr>
    <td><img src='https://imageserver.eveonline.com/Character/{{ $fleet->getfc()->id }}_32.jpg' height='24' /></td>
    <td>{{$fleet->getfc()->name}}</td>
    <td>{{$fleet->created_at}}</td>
    <td>@if($fleet->getfc()->id == auth()->user()->id)
        <a href="" class="btn btn-danger">End Fleet </a>
        @else
            @if($fleet->punches()->where('user_id', auth()->user()->id))
                <a href="" class="btn btn-danger">End Fleet </a>
                @else
            <a href="" class="btn btn-success">Join Fleet </a>
                @endif
            @endif

    </td>
</tr>