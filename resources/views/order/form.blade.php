{!! Form::open(['url' => $url, 'method' => $method, 'class' => 'form-horizontal']) !!}  
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
        <label for="user_id" class="col-md-4 control-label">User ID (Customer)</label>

        <div class="col-md-6">
            <input list="users" name="user_id" class="form-control">
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

    <div class="form-group{{ $errors->has('recipient_name') ? ' has-error' : '' }}">
        <label for="recipient_name" class="col-md-4 control-label">Delivery Addressee</label>

        <div class="col-md-6">
            {{ Form::text('recipient_name', $order->recipient_name, ['class' => 'form-control']) }}

            @if ($errors->has('recipient_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('recipient_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('line1') ? ' has-error' : '' }}">
        <label for="line1" class="col-md-4 control-label">Delivery Address</label>

        <div class="col-md-6">
            {{ Form::text('line1', $order->line1, ['class' => 'form-control']) }}

            @if ($errors->has('line1'))
                <span class="help-block">
                    <strong>{{ $errors->first('line1') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
        <label for="city" class="col-md-4 control-label">City</label>

        <div class="col-md-6">
            {{ Form::text('city', $order->city, ['class' => 'form-control']) }}

            @if ($errors->has('city'))
                <span class="help-block">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
        <label for="postal_code" class="col-md-4 control-label">Postal Code</label>

        <div class="col-md-6">
            {{ Form::number('postal_code', $order->postal_code, ['class' => 'form-control']) }}

            @if ($errors->has('postal_code'))
                <span class="help-block">
                    <strong>{{ $errors->first('postal_code') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
        <label for="state" class="col-md-4 control-label">Province</label>

        <div class="col-md-6">
            {{ Form::text('state', $order->state, ['class' => 'form-control']) }}

            @if ($errors->has('state'))
                <span class="help-block">
                    <strong>{{ $errors->first('state') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('country_code') ? ' has-error' : '' }}">
        <label for="country_code" class="col-md-4 control-label">Country Code</label>

        <div class="col-md-6">
            {{ Form::text('country_code', $order->country_code, ['class' => 'form-control']) }}

            @if ($errors->has('country_code'))
                <span class="help-block">
                    <strong>{{ $errors->first('country_code') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        <label for="payment_method" class="col-md-4 control-label">Payment Method</label>

        <div class="col-md-6">
            {{ Form::select('payment_method', ['Credit Card' => 'Credit Card', 'PayPal' => 'PayPal'], $order->payment_method, ['class' => 'form-control']) }}
            @if ($errors->has('payment_method'))
                <span class="help-block">
                    <strong>{{ $errors->first('payment_method') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="col-md-4 control-label">PayPal Account</label>

        <div class="col-md-6">
            {{ Form::email('email', $order->email, ['class' => 'form-control']) }}

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        <label for="status" class="col-md-4 control-label">Status</label>

        <div class="col-md-6">
            {{ Form::select('status', ['Created' => 'Created', 'Approved' => 'Approved', 'In Progress' => 'In Progress', 'Completed' => 'Completed', 'Cancelled' => 'Cancelled'], $order->status, ['class' => 'form-control', 'placeholder' => 'Status of the order...']) }}
            @if ($errors->has('status'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('total') ? ' has-error' : '' }}">
        <label for="total" class="col-md-4 control-label">Total</label>

        <div class="col-md-6">
            {{ Form::number('total', $order->total, ['class' => 'form-control']) }}

            @if ($errors->has('total'))
                <span class="help-block">
                    <strong>{{ $errors->first('total') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group text-center">
        <input type="submit"  value="Save" class="btn btn-success">
        <a href="{{ route('orders.index') }}" class="btn btn-info" >Back</a>
    </div>   
{!! Form::close() !!}