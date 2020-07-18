@if(count($pictures)>0)
    <ul class="list-unstyled">
        @foreach($pictures as $picture)
            <li class="media mb-3">
                {{--投稿者のメールアドレスをもとにGravatarを取得して表示--}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($picture->user->email,['size'=>50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{--投稿の所有者のユーザ詳細ページへのリンク--}}
                        {!! link_to_route('users.show',$picture->user->name,['user'=>$picture->user->id]) !!}
                        <span class="text-muted">posted at {{ $picture->created_at }}</span>
                    </div>
                    <div>
                        {{--投稿内容--}}
                        <p class="mb-0">{!! nl2br(e($picture->content)) !!}</p>
                    </div>
                    <div>
                        @if(Auth::id() == $picture->user_id)
                            {{--投稿削除ボタンのフォーム--}}
                            {!! Form::open(['route'=>['pictures.destroy',$picture->id],'method'=>'delete']) !!}
                                {!! Form::submit('削除',['class'=>'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif    
                    </div>
                </div>
            </li>
        @endforeach    
    </ul>
    {{--ページネーションのリンク--}}
    {{ $pictures->links() }}
@endif    