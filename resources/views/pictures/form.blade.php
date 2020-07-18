{!! Form::open(['route'=>'pictures.store']) !!}
    <div class="form-group">
        {!! Form::textarea('content',old('content'),['class'=>'form-control','rows'=>'2']) !!}
        {!! Form::submit('post',['class'=>'btn btn-primary btn-block']) !!}
    </div>
{!! Form::close() !!}    