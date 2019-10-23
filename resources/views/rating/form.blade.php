{!! Form::open(['url' => $url, 'method' => $method, 'class' => 'form-horizontal']) !!}  
    {{ csrf_field() }}

        <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
        <label for="user_id" class="col-md-4 control-label">User ID</label>

        <div class="col-md-6">
            <input list="users" name="user_id" value="{{old('user_id')}}" class="form-control">
            <datalist id="users">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{$user->first_name}} {{$user->last_name}}</option>
                @endforeach
            </datalist>
            @if ($errors->has('user_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('score') ? ' has-error' : '' }}">
        <label for="score" class="col-md-4 control-label">Score</label>
        <div class="col-md-6">
            {{ Form::select('score',[1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], $rating->score, ['class' => 'form-control']) }}

            @if ($errors->has('score'))
                <span class="help-block">
                    <strong>{{ $errors->first('score') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
        <label for="comment" class="col-md-4 control-label">Comment</label>
        <div class="col-md-6">
            {{ Form::text('comment', $rating->comment, ['class' => 'form-control']) }}

            @if ($errors->has('comment'))
                <span class="help-block">
                    <strong>{{ $errors->first('comment') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('article_id') ? ' has-error' : '' }}">
        <label for="article_id" class="col-md-4 control-label">Article ID</label>
        <div class="col-md-6">
            <input list="articles" name="article_id" value="{{old('article_id')}}" class="form-control">
            <datalist id="articles">
                @foreach($articles as $article)
                    <option value="{{ $article->id }}">{{$article->name}}</option>
                @endforeach
            </datalist>
            @if ($errors->has('article_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('article_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group text-center">
        <input type="submit"  value="Save" class="btn btn-success">
        <a href="{{ route('ratings.index') }}" class="btn btn-info" >Back</a>
    </div>
    
{!! Form::close() !!}