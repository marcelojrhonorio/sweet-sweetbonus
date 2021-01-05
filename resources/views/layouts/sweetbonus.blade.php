<!doctype html>
<html lang="pt-BR">
<head>
  {{-- Smartlook --}}
  @if(isset($smartlook) and $smartlook)
  <script type="text/javascript">
    window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', '61b3a2c17500f94556c7660cc941487ed0b8a74c');
  </script>
  @endif

  {{-- Required meta tags --}}
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  @if('uat-sweetbonus' == $domain)
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex">
  @endif

  {{-- OneSignal Web Push--}}
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
  <script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
      OneSignal.init({
      appId: "633cc1ed-e7da-4c1e-b92d-cf22807ef5e4",
      });
  });
  </script>
  
  {{-- CSS --}}
  @if('home' === $page)
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  @else
  <link rel="stylesheet" href="{{ asset('css/sweet.css') }}">
  @endif

  {{-- Fonte Awesome --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  {{-- Icon --}}
  @if('xmove-car' === $page)
    <link rel="icon" href="{{ asset('images/subpage/xmove-car/favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('images/subpage/xmove-car/favicon.ico') }}" type="image/x-icon"/>
  @else
    <link rel="icon" href="{{ asset('images/subpage/favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('images/subpage/favicon.ico') }}" type="image/x-icon"/>
  @endif
 

  @if('xmove-car' === $page)
    <title>XMove Car</title>
  @else
    <title>Sweet Bonus</title>
  @endif

  {{-- Global site tag (gtag.js) - Google Analytics --}}
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115220710-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-115220710-1');
  </script>

  {{-- Push Notifications --}}
  {{--  Disabled the push script because the Bruno requested for it on based SWEET-144  --}} 
  {{--  <script charset="UTF-8" src="https://cdn.sendpulse.com/9dae6d62c816560a842268bde2cd317d/js/push/17fb21123b6d3afb501c22b3aefe7aef_1.js" async></script>  --}}

  <style>
    .footer-link,
    .footer-link:focus,
    .footer-link:hover {
      color: #ffffffb0;
    }
  </style>
  
  {{-- Facebook Pixel --}}
  @include('layouts.includes.js.pixels.facebook-pixel')

</head>
<body>

  @yield('content')

  <script src="{{ asset('js/sweet.js') }}"></script>

  <script>
    jQuery(document).ready(function(){
      {{-- AUTO SCROLL --}}
      $('.scroll').click(function() {
        var elementClicked = $(this).attr('href');
        var destination = $(elementClicked).offset().top-40;
        $('html:not(:animated),body:not(:animated)').animate({ scrollTop: destination }, 1000 );
        return false;
      });
    });
  </script>
</body>
</html>
