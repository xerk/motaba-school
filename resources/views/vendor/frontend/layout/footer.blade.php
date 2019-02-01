<div id="footer" data-sticky-footer>
    <div class="uk-section-default uk-section uk-section-large">
        <div class="uk-container">
            <div class="uk-grid-large uk-grid-margin-large uk-grid" uk-grid="">
                <div class="uk-width-expand@m uk-width-1-2@s uk-first-column uk-footer-logo">
                    <div class="uk-margin">
                        <a href="/"><img src="https://wave.devdojo.com/storage/themes/August2018/TksmVWMqp5JXUQj8C6Ct.png"
                                data-src="https://wave.devdojo.com/storage/themes/August2018/TksmVWMqp5JXUQj8C6Ct.png"
                                style="height:16px;"></a>
                    </div>
                    <div class="uk-margin uk-width-xlarge">{{ Session::get('locale') == 'en' ? setting('site.home_description') : setting('site.home_description_ar') }}</div>
                </div>
                <div class="uk-width-expand@m uk-width-1-2@s">
                    <h3 class="uk-h5">{{__('Site Links')}}</h3>
                    <ul class="uk-list">
                        <li><a href="{{ route('frontend.home')}}" class="uk-link-muted">{{ __('Homepage') }}</a></li>
                        <li><a href="{{ route('frontend.news')}}" class="uk-link-muted">{{ __('News') }}</a></li>
                        <li><a href="{{ route('frontend.gallery')}}" class="uk-link-muted">{{ __('Gallery') }}</a></li>
                    </ul>
                </div>
                <div class="uk-width-expand@m uk-width-1-2@s">
                    <h3 class="uk-h5">{{ __('Kamel Ouda Resources') }}</h3>
                    <ul class="uk-list">
                        <li><a href="{{ route('frontend.blogs')}}" class="uk-link-muted">{{ __('Blogs') }}</a></li>                        
                        <li><a href="{{ url('\about')}}" class="uk-link-muted">{{ __('About') }}</a></li>                        
                        <li><a href="{{ route('frontend.contact')}}" class="uk-link-muted">{{ __('Contact') }}</a></li>                        
                    </ul>
                </div>
                <div class="uk-width-expand@m uk-width-1-2@s">
                    <h3 class="uk-h5">{{ __('Contact Us') }}</h3>
                    <div class="uk-margin">contact@kamel-ouda.com</div>
                    <div class="uk-margin">
                        <div class="uk-child-width-auto uk-grid-medium uk-grid uk-social" uk-grid>
                            <a uk-icon="icon: youtube; ratio: 0.8" href="#" target="_blank"
                                class="el-link uk-link-muted uk-icon"></a>
                            <a uk-icon="icon: instagram; ratio: 0.8" href="#"
                                target="_blank" class="el-link uk-link-muted uk-icon"></a>
                            <a uk-icon="icon: twitter; ratio: 0.8" href="#" target="_blank"
                                class="el-link uk-link-muted uk-icon"></a>
                            <a uk-icon="icon: facebook; ratio: 0.8" href="#"
                                target="_blank" class="el-link uk-link-muted uk-icon"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('themes/uikit/js/app.js') }}"></script>