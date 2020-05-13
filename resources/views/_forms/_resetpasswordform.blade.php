<div class="modal-wrapper login-form">
    <div class="login-container steps">
        <div class="signin-form email-form">
            <div class="hdr">{{ trans('passwords.resetpass') }}</div>
            <form  role="form" method="POST" action="{{ route('password.reset') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="emailbox">
                    <label>{{ trans('passwords.passemail') }}</label>
                    <input type="email" class="cd-input" name="email" value="{{ $email or old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="passwordbox">
                    <label>{{ trans('passwords.passpassword') }}</label>
                    <input id="password" name="password" class="cd-input"  type="password" >
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="passwordbox">
                    <label>{{ trans('passwords.passpasswordconf') }}</label>
                    <input id="password_confirmation" name="password_confirmation" class="cd-input"  placeholder="{{ trans('passwords.passpasswordconf') }}" type="password" >
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <br>
                <button type="submit" class="button button-orange button-full"> {{ trans('passwords.resetpass') }}</button>
            </form>
        </div>
    </div>
</div>