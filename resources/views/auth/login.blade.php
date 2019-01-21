@extends('vendor.frontend.layout.layout')

@section('content')
<div class="uk-section">
    <div class="uk-container uk-container-center">
        <div class="uk-width-1-2@m uk-align-center">
            <div class="uk-padding uk-box-shadow-large">
                <h2>{{__('voyager::generic.login')}}</h2>
                <form class="uk-form-stacked" role="form" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @csrf
                    <div>
                        <label class="uk-form-label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="text" class="uk-input{{ $errors->has('email') ? ' uk-form-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <div class="uk-alert-danger uk-alert" uk="alert">
                               {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="uk-input{{ $errors->has('password') ? ' uk-form-danger' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <div class="uk-alert-danger uk-alert" uk="alert">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="uk-margin">
                        <label><input class="uk-checkbox" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}</label>
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary" type="submit" name="button">{{ __('Login') }}</button>
                        <a class="uk-float-right" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
