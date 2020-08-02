@if(count($pictures)>0)
    <ul class="list-unstyled">
        @foreach($pictures as $picture)
            <li class="media mb-3">
               
                     <img data-toggle="modal" data-target="#picture-{{ $picture->id }}" src="{{ asset($picture->picture_url) }}" width="200" hight="16
                     0" alt="no image">
                <!--{{--投稿者のメールアドレスをもとにGravatarを取得して表示--}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($picture->user->email,['size'=>50]) }}" alt="">-->
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
                       <!-- @if($picture->picture_url)
                            <img src="{{ asset('storage/'.$picture->picture_url) }}" width="40" height="40" alt="no image"/>
                        @else
                            <p>-----</p>
                        @endif  -->
                    <div>
                        @if(Auth::user()->is_favorites($picture->id))
                           {{--お気に入り解除ボタンのフォーム--}}
                           {!! Form::open(['route'=>['favorites.unfavorite',$picture->id],'method'=>'delete']) !!}
                               {!! Form::submit('いいね解除',['class'=>'btn btn-success btn-sm']) !!}
                           {!! Form::close() !!}
                        @else
                            {{--お気に入りボタンのフォーム--}}
                            {!! Form::open(['route'=>['favorites.favorite',$picture->id]]) !!}
                                {!! Form::submit('いいね',['class'=>'btn btn-default btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                        @if(Auth::id() == $picture->user_id)
                            {{--投稿削除ボタンのフォーム--}}
                            {!! Form::open(['route'=>['pictures.destroy',$picture->id],'method'=>'delete']) !!}
                                {!! Form::submit('削除',['class'=>'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif    
                    </div>
                </div>
            </li>
           <!-- <img data-toggle="modal" data-target="#$picture->id" src="$picture->id">-->
               <!-- モーダルで表示させる画像：最初は隠れている -->
               <div class="modal fade" id="picture-{{ $picture->id }}" tabindex="-1" role="dialog" aria-labelledby="picture-{{ $picture->id }} Label" aria-hidden="true">
               <div class="modal-dialog" role="document">
               <div class="modal-content">
               <div class="modal-header">
               <!-- タイトル -->
               <h5 class="modal-title" id="exampleModalLabel">ズーム</h5>
               <!-- 閉じるボタン -->
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
               </div>
                 <div class="modal-body">
               <img src="{{ asset($picture->picture_url) }}">
               </div>
               </div>
               </div>
               </div>
        @endforeach    
    </ul>
    {{--ページネーションのリンク--}}
    {{ $pictures->links() }}
@endif    