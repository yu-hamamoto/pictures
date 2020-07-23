        <form method="post" action="{{ route('upload') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="select_id" value="">
            
            <div class="form-group row">
                <!--<label for="picture_url" class="col-md-3 col-form-label text-md-left">{ _('イメージ') }}</label>-->
            
                <div class="col-md-7">
                    <input type="file" name="picture_url" value="" style="border:none;">
                    <!--<small class="input_condidion">*jpg.png形式のみ</small></br>
                    <small class="input_condidion">*最小画像サイズ：縦横１００px</small></br>
                    <small class="input_condidion">*最大画像サイズ：縦横６００px</small>-->
                    
                    <label for="picture_url" class="col-md-3 col-form-label text-md-left"><!--{{ _('イメージ') }}--></label>
                    
                    @if($errors->has('picture_url'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('picture_url') }}</strong>
                        </span>
                    @endif    
                </div>
           <!-- </div>
        
    　　　　　　　　<div class="form-group">-->
        　　　　　　　　{!! Form::textarea('content',old('content'),['class'=>'form-control','rows'=>'2']) !!}
        　　　　　　　　{!! Form::submit('投稿',['class'=>'btn btn-primary btn-block']) !!}
    　　　      </div>
　　　　　　</form>