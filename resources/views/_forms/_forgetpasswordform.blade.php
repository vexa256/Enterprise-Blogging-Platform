<div class="modal-wrapper login-form">
    <div class="login-container steps">
        <div class="signin-form email-form">
            <div class="hdr">{{ trans('passwords.resetpass') }}</div>
            {!! Form::open(array('route' => 'password.email', 'method' => 'POST', 'onsubmit' => 'return false')) !!}
                <div class="emailbox">
                     <input type="email" class="cd-input" name="email" value="{{ old('email') }}" placeholder="{{ trans('passwords.passemail') }}">
                </div>
                <br>
                <button type="submit" class="button button-orange button-full" id="PostPasswordLogin"> {{ trans('passwords.passwordreslink') }}</button>
            {!! Form::close() !!}
        </div>
        <br>
    </div>
</div>
