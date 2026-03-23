@extends('site.pages.ultralims.layout')
@push('head')
    <style>
        .wpp-button{
            display: none;
        }
    </style>
@endpush
@section('content')

@endsection
@push('scripts')
    {{-- RocketChat --}}
    {{--
    <script type="text/javascript">
        (function(w, d, s, u) {
            w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;
            var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
            j.async = true; j.src = 'https://atendimento.ultralims.com.br/livechat/rocketchat-livechat.min.js?_=201903270000';
            h.parentNode.insertBefore(j, h);
        })(window, document, 'script', 'https://atendimento.ultralims.com.br/livechat');
    </script>
    --}}
    
    <script>
      (function(d,t) {
        var BASE_URL="https://chatwoot-impetus-e053997ad769.herokuapp.com/";
        var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=BASE_URL+"/packs/js/sdk.js";
        g.defer = true;
        g.async = true;
        s.parentNode.insertBefore(g,s);
        g.onload=function(){
          window.chatwootSDK.run({
            websiteToken: 'cCUdPciK6XqcrvsB2poC1ju2',
            baseUrl: BASE_URL
          })
        }
      })(document,"script");
    </script>
@endpush
