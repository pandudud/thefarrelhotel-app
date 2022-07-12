<li class="dd-item dd3-item{{$all_menu->is_heading?' dd-nochildren':''}}" data-id="{{$all_menu->id}}" data-heading="{{$all_menu->is_heading?'true':'false'}}">
    <div class="btn-group btn-group-solid" style="float:right;">
        <a href="{{url('pengaturan/menu').'/'.$all_menu->id.'/ubah'}}" class="btn purple-sharp btn-menu btn-menu-left"><i class="glyphicon glyphicon-edit"></i></a>
        {!!Form::open([ 'method'  => 'delete', 'route' => [ 'menu.destroy', $all_menu->id ], 'style' => 'display: inline-block;' ]) !!}
            <btn type="submit" class="btn red-haze btn-menu btn-menu-right btn-delete" data-swa-text="{{$all_menu->name}}"><i class="glyphicon glyphicon-trash"></i></btn>
        {!! Form::close() !!}
    </div>
    <div class="dd-handle dd3-handle bg-theme"></div>
    <div class="dd3-content"> <i class="{{ $all_menu->icon }}"></i> {{$all_menu->name}}</div>
    @if(count($all_menu->allchildrens) > 0)
    <ol class="dd-list">
        @foreach ($all_menu->allchildrens as $all_menu)
            @include('pengaturan.menu.data', $all_menu)
        @endforeach
    </ol>
    @endif
</li>