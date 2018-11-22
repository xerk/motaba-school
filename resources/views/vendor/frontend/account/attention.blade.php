@extends('vendor.frontend.layout.layout')
@section('title', Auth::user()->name.' Profile')
@section('body-class', 'at-'.Auth::user()->username)
@section('extra-css')
<style>
.uk-card-body .attention-section {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.09   );
    padding: 10px 15px 10px;
    color: black;
}
.uk-accordion-content {
    border-top: 1px solid #ddd;
}
.body-attention {
    padding: 10px 15px 10px;
}
.show-result {
    font-weight: 600;
}
</style>
@endsection
@section('content')
<div class="uk-container uk-margin-top settings">
    <div class="uk-text-left" uk-grid>
        <div class="uk-width-1-4@m">
            <div class="uk-card uk-card-default uk-card-nav">
                <div class="uk-card-header">
                    <h5>Attentions Type</h5>
                </div>
                <div class="uk-card-body">
                    <ul class="settings-links">
                            <li class="{{ Request::is('attentions/@'.Auth::user()->username) ? 'active' : '' }} tablink"><a href="{{ route('frontend.attentions', Auth::user()->username) }}" class="setting-link"> <span
                                uk-icon="icon: bell" class="uk-icon"></span>All Attentions</a></li>
                        @foreach ($attentionTypes as $item)    
                            <li class="{{ Request::is('attentions/@'.Auth::user()->username.'/'.$item->id) ? 'active' : '' }} tablink"><a href="{{ route('frontend.attention.show', [Auth::user()->username, $item->id]) }}" class="setting-link"> <span
                                    uk-icon="icon: list" class="uk-icon"></span>{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-width-3-4@m uk-margin-medium-bottom">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <h5><span uk-icon="icon: user" class="uk-icon"></span>{{ Auth::user()->name }}&#039;s Attention(s)</h5>
                </div>
                <div id="attention" class="uk-card-body">
                    @if (Request::is('attentions/@'.Auth::user()->username))
                        <ul uk-accordion>
                            @foreach ($attentions as $item)    
                                <li v-if="{{ $loop->index }} >= attentionShow"></li>
                                <li v-else class="{{ $loop->first ? 'uk-open' : '' }} attention-section">
                                    <a class="uk-accordion-title" href="#">
                                        <span>{{ $loop->iteration }} - {{ $item->attentionTypes->name }}</span>
                                    </a>
                                    <div class="uk-accordion-content body-attention">
                                        <div>
                                            {!! $item->body !!}
                                        </div>
                                        <span class="uk-flex-right"></span>
                                        <p class="uk-text-meta uk-margin-remove-top" style="float: right"><time datetime="{{ $item->end_date }}" title="{{$item->end_date}}">{{ \Carbon\Carbon::parse($item->end_date)->toFormattedDateString() }}</time></p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <span class="show-result">
                            <hr>
                            <a @click.prevent="attentionShow = attentionShow + 5" href="">Show More</a> <span v-if="attentionShow != 1">|</span> <a v-if="attentionShow != 1" @click.prevent="attentionLess()" href="">Show Less</a> 
                            <p class="uk-text-meta uk-margin-remove-top" style="float: right"><time>@{{ attentionShow }}</time></p>
                        </span>
                    @else
                        <ul uk-accordion>
                            @foreach ($attentionType as $item)    
                                <li v-if="{{ $loop->index }} >= attentionShow"></li>
                                <li v-else class="{{ $loop->first ? 'uk-open' : '' }} attention-section">
                                    <a class="uk-accordion-title" href="#">
                                        <span>{{ $loop->iteration }} - {{ $item->attentionTypes->name }}</span>
                                    </a>
                                    <div class="uk-accordion-content body-attention">
                                        <div>
                                            {!! $item->body !!}
                                        </div>
                                        <span class="uk-flex-right"></span>
                                        <p class="uk-text-meta uk-margin-remove-top" style="float: right"><time datetime="{{ $item->end_date }}" title="{{$item->end_date}}">{{ \Carbon\Carbon::parse($item->end_date)->toFormattedDateString() }}</time></p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <span class="show-result">
                            <hr>
                            <a @click.prevent="attentionShow = attentionShow + 5" href="">Show More</a> <span v-if="attentionShow != 1">|</span> <a v-if="attentionShow != 1" @click.prevent="attentionLess()" href="">Show Less</a> 
                            <p class="uk-text-meta uk-margin-remove-top" style="float: right"><time>@{{ attentionShow }}</time></p>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="https://unpkg.com/vue"></script>
    <script>
        const app = new Vue({
            el: '#attention',
            data() {
                return {
                    attentionShow: 5,
                }
            },
            methods: {
                attentionLess() {
                    this.attentionShow = this.attentionShow - 5 
                    if (this.attentionShow == 0) {
                        this.attentionShow = 1
                    }
                }
            }
        })
    </script>
@endsection