@auth
<div class="uk-nav-container">
    <div class="uk-container">
        <nav class="uk-navbar-container uk-margin uk-navbar-transparent" uk-navbar>
            <div class="uk-navbar-left uk-logo-container">
                <a class="uk-navbar-item uk-logo" href="/"><img src="{{ Voyager::image(setting('site.logo_colored')) }}"
                        style="height:35px;"></a>
            </div>
            <div id="uk-nav-left-mobile"><span class="more-btn" uk-icon="menu"></span><span class="close-btn uk-icon"
                    uk-icon="close"></span></div>
            <div class="uk-navbar-left uk-margin-left">
                <ul class="uk-navbar-nav" id="uk-nav-left">
                    @foreach($items as $menu_item)

                    @if($menu_item->children->isEmpty())
                    <li class="{{ Request::is($menu_item->link()) ? 'uk-active' : '' }}">
                        <a href="{{ $menu_item->link() }}" target="{{$menu_item->target}}">
                            <span uk-icon="icon: {{ $menu_item->icon_class}}"></span>
                            <span>{{ Session::get('locale') == 'en' ? $menu_item->title : $menu_item->title_ar }}</span>
                        </a>
                    </li>
                    @else
                    <li class="dropdown">
                        <a href="#_" target="{{ $menu_item->target }}" style="" class="dropdown-toggle" data-toggle="dropdown">
                            <span uk-icon="icon: {{ $menu_item->icon_class }}"></span>
                            <span> {{ Session::get('locale') == 'en' ? $menu_item->title : $menu_item->title_ar }}</span>
                            <span class="caret"></span>
                        </a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                @foreach($menu_item->children as $item)
                                <li class="">
                                    <a href="{{ $item->title }}" target="{{ $item->target }}" style="">
                                        <span uk-icon="icon: {{ $item->icon_class}}"></span>
                                        <span> {{ Session::get('locale') == 'en' ? $item->title : $item->title_ar }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endif
                    @endforeach

                </ul>
            </div>
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav uk-navbar-auth" id="uk-nav-right">
                </a>
                <li class="dropdown">
                        <a href="#_" target="" style="" class="dropdown-toggle" data-toggle="dropdown">
                            <span><i uk-icon="location"></i> {{ Session::get('locale') == 'en' ? 'English' : 'عربي' }}</span>
                            <span class="caret"></span>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="">
                                    <a href="{{ route('frontend.locale', 'en') }}" target="" style="">
                                        <span> English</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('frontend.locale', 'ar') }}" target="" style="">
                                        <span> عربي</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li id="notification-list">
                        <a href="#_" uk-toggle="target: #notifications" id="notification-icon">
                            <span uk-icon="icon: bell"></span>
                        </a>
                        <div class="uk-navbar-dropdown uk-notification-dropdown">
                            <div id="notification-header">
                                <div id="notification-head-content">
                                    <span uk-icon="icon: bell"></span> Notifications
                                </div>
                            </div>
                            <div id="notifications-none" class="">
                                <span uk-icon="icon: bell; ratio: 2" style="display:block; position:relative; opacity:0.5"></span>
                                All Caught Up!
                            </div>
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                            </ul>
                            <div id="notification-footer">
                                <a href="https://wave.devdojo.com/notifications"><span uk-icon="icon: eye"></span>View
                                    All Notifications</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#_" class="user-icon">
                            <img src="{{ Voyager::image(Auth::user()->avatar) }}">
                            <span uk-icon="icon: triangle-down"></span>
                        </a>
                        <div class="uk-navbar-dropdown uk-user-dropdown" id="user-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="user-dropdown-info">
                                    <img src="{{ Voyager::image(Auth::user()->avatar) }}">
                                    <div>
                                        <p>{{ Auth::user()->name }}</p>
                                        <span>{{ '@'.Auth::user()->username }}</span>
                                    </div>
                                </li>
                                {{-- <li>
                                    <div class="uk-label uk-label-success uk-label-plan" style="background:#237182">Premium
                                        Plan</div>
                                </li> --}}

                                @if (Voyager::can('browse_admin'))
                                <li><a href="{{ route('voyager.dashboard') }}"><span uk-icon="icon: bolt"></span>Admin</a></li>
                                @endif
                                <li><a href="{{ route('frontend.profile', Auth::user()->username) }}"><span uk-icon="icon: user"></span>My
                                        Profile</a></li>
                                <li><a href="{{ route('frontend.attentions', Auth::user()->username) }}"><span uk-icon="icon: thumbnails"></span>Attentions</a></li>
                                {{-- <li><a href="{{ route('frontend.setting') }}"><span uk-icon="icon: cog"></span>Settings</a></li> --}}
                                <li class="uk-hidden@m"><a href="https://wave.devdojo.com/notifications"><span uk-icon="icon: bell"></span>My
                                        Notifications</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span
                                            uk-icon="icon: sign-out"></span>Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <div id="uk-nav-right-mobile"><span class="more-btn" uk-icon="more-vertical"></span><span class="close-btn uk-icon"
                        uk-icon="close"></span></div>
            </div>
        </nav>
    </div>
</div>
@else
<div>
    <div class="uk-nav-container" uk-sticky>
        <div class="uk-container">
            <nav class="uk-navbar-container uk-margin uk-navbar-transparent" uk-navbar>
                <div class="uk-navbar-left uk-logo-container">
                    <a class="uk-navbar-item uk-logo" href="index.html"><img src="{{ Voyager::image(setting('site.logo_colored')) }}"
                            style="height:35px;"></a>
                </div>
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav " id="uk-nav-right">
                        @foreach($items as $menu_item)
                        @if($menu_item->children->isEmpty())
                        <li class="{{ Request::is($menu_item->link()) ? 'uk-active' : '' }}">
                            <a href="{{ $menu_item->link() }}" target="{{$menu_item->target}}">
                                <span>{{ Session::get('locale') == 'en' ? $menu_item->title : $menu_item->title_ar }}</span>
                            </a>
                        </li>
                        @else
                        <li class="dropdown">
                            <a href="#_" target="{{ $menu_item->target }}" style="" class="dropdown-toggle" data-toggle="dropdown">
                                <span> {{ Session::get('locale') == 'en' ? $menu_item->title : $menu_item->title_ar }}</span>
                                <span class="caret"></span>
                            </a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    @foreach($menu_item->children as $item)
                                    <li class="">
                                        <a href="{{ $item->link() }}" target="{{ $item->target }}" style="">
                                            <span> {{ Session::get('locale') == 'en' ? $item->title : $item->title_ar }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endif
                        @endforeach
                        <li class="dropdown">
                            <a href="#_" target="" style="" class="dropdown-toggle" data-toggle="dropdown">
                                <i uk-icon="location"></i> {{ Session::get('locale') == 'en' ? 'English' : 'عربي' }}
                                <span class="caret"></span>
                            </a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li class="">
                                        <a href="{{ route('frontend.locale', 'en') }}" target="" style="">
                                            <span> English</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('frontend.locale', 'ar') }}" target="" style="">
                                            <span> عربي</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('login') }}"><button class="uk-button uk-button-primary">{{ __('voyager::generic.login') }}</button></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
@endauth
