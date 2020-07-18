@if(Auth::id() != $user->id)
    @if(Auth::user()->is_following($user->id))
        {{--アンフォローボタンのフォーム--}}
        {!! Form::open(['route'=>['user.unfollow',$user->id],'method'=>'delete']) !!}
            {!! Form::submit('アンフォロー',['class'=>'btn btn-danger btn-block']) !!}
        {!! Form::close() !!}
    @else
        {{--フォローボタンのフォーム--}}
        {!! Form::open(['route'=>['user.follow',$user->id]]) !!}
            {!! Form::submit('フォロー',['class'=>'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
    @endif
@endif    