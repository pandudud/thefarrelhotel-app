<li style="list-style: none; margin-bottom: 10px;">
    <div class="md-checkbox">
        @if(!$all_menu->is_heading)
        <input type="checkbox" id="{{$all_menu->id}}cb" data-menu-id="{{$all_menu->id}}" class="md-check">
        <label for="{{$all_menu->id}}cb">
            <span></span>
            <span class="check"></span>
            <span class="box"></span> <i class="{{$all_menu->icon}}"></i> {{$all_menu->name}}
        </label>
        @else
        {{$all_menu->name}}
        @endif
    </div>
</li>
@if(count($all_menu->allchildrens) > 0)
    <ul style="margin-left: -10px;">
    @foreach ($all_menu->allchildrens as $all_menu)
        @include('pengaturan.hak-akses.data', $all_menu)
    @endforeach
    </ul>
@endif