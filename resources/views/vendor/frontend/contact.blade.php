@extends('vendor.frontend.layout.layout')
@section('title', __('Contact Us'))
@section('content')
<div class="uk-section">
    <div class="uk-container uk-container-center">
        <div dir="auto" class="uk-margin-medium-bottom uk-text-left uk-margin-large-top">
            <h1 class="uk-heading-line uk-margin-remove-top uk-text-center"><span>{{__('Contact Us')}}</span></h1>
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                            <div class="uk-alert-{{ $msg }}" uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <p>{{ Session::get('alert-' . $msg) }}</p>
                            </div>
                            @endif
                        @endforeach
        </div>
        <div class="uk-width-1-2@m uk-align-center" dir="auto">
            <div class="uk-padding uk-box-shadow-large">
                <form class="uk-form-stacked" role="form" method="POST" action="{{ route('frontend.contact.store') }}" aria-label="{{ __('Contact Us') }}">
                    @csrf
                    <div class="uk-margin">
                        <label class="uk-form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" class="uk-input{{ $errors->has('name') ? ' uk-form-danger' : '' }}"
                            name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    <div class="uk-child-width-expand@s" uk-grid uk-height-match="target: > div > .uk-card">
                        <div>
                            <label class="uk-form-label">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="text" class="uk-input{{ $errors->has('email') ? ' uk-form-danger' : '' }}"
                                name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                            <div class="uk-alert-danger uk-alert" uk="alert">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>
                        <div>
                            <label class="uk-form-label">{{ __('Phone') }}</label>
                            <input id="phone" type="text" class="uk-input{{ $errors->has('phone') ? ' uk-form-danger' : '' }}"
                                name="phone" required>
                            @if ($errors->has('phone'))
                            <div class="uk-alert-danger uk-alert" uk="alert">
                                {{ $errors->first('phone') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label">{{ __('Subject') }}</label>
                        <input id="subject" type="text" class="uk-input{{ $errors->has('subject') ? ' uk-form-danger' : '' }}"
                            name="subject" value="{{ old('subject') }}" required autofocus>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label">{{ __('Message') }}</label>
                        <textarea name="message" class="uk-textarea" id="message" placeholder="{{ __('Message') }}"
                            cols="30" rows="3"></textarea>
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary" type="submit" name="button">{{ __('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        {{-- <dl class="uk-description-list uk-description-list-divider">
            <dt>Phone</dt>
            <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</dd>
            <dt>Description term</dt>
            <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</dd>
            <dt>Description term</dt>
            <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</dd>
        </dl> --}}
    </div>
</div>
@endsection
