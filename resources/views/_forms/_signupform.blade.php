<div class="modal-wrapper signup-form">

    @include("_particles.connect_buttons")

    <div class="login-container steps">

        <div class="signin-form email-form">
            <div class="hdr">{{ trans('index.registerwithemail') }}</div>
            {!! Form::open(array('action' => array('Auth\RegisterController@register', 'redirectTo' => Request::query('redirectTo') ), 'method' => 'POST', 'onsubmit' => 'return false')) !!}
                <div class="usernamebox">
                    <input  id="username" class="cd-input" name="username" placeholder="{{ trans('index.username') }}" type="text" value="{{ Session::get('username') !== null  ? Session::get('username') : "" }}">
                </div>
                <div class="emailbox">
                    <input id="email" name="email" class="cd-input" placeholder="{{ trans('index.email') }}" type="email" value="">
                </div>
                <div class="passwordbox">
                    <input id="password" name="password" class="cd-input"  placeholder="{{ trans('index.password') }}" type="password">
                </div>
                <div class="under-email-signin clearfix">
                    <div class="forgot-pass">
                        {!!  trans('index.termslink', ['url' => '<a href="'.get_buzzy_config('termspage').'" target="_blank">'.trans('index.terms').'</a>']) !!}
                    </div>
                </div>
                @if(get_buzzy_config('BuzzyRegisterCaptcha')=="on" && get_buzzy_config('reCaptchaKey') !== '')
                    <div class="under-email-signin clearfix" style="overflow: hidden;">
                        <label>{{ trans('buzzycontact.areyouhuman') }}</label>
                        <script src='https://www.google.com/recaptcha/api.js'></script>
                        <div class="g-recaptcha clearfix" data-sitekey="{{  get_buzzy_config('reCaptchaKey') }}"></div>
                    </div>
                @endif
                <button type="button" class="button button-orange button-full" style="margin-top:5px" id="PostNewUser">{{ trans('index.register') }}</button>
            {!! Form::close() !!}
        </div>
        <div class="signup-terms">
            <div class="show-connect-forms">
            {{ trans('index.Doyouhaveanaccount') }} <a href="{{ route('login') }}" @if(!isset($link)) rel="get:Loginform" @endif>{{ trans('index.login') }}</a>
            </div>
        </div>
    </div>


</div>
