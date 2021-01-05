<!DOCTYPE html>
<html lang="pt-BR">
<head>
  
  <base href="/">

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/navigation.css?{{time()}}">
  <link rel="stylesheet" type="text/css" href="assets/css/campaigns.css?{{time()}}">
  <link rel="stylesheet" type="text/css" href="assets/js/library/toastr/toastr.css?{{time()}}">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

  <title>Sweet Bonus :: @yield('title')</title>

  <style type="text/css">
    .error {
      border: 1px solid #ff0000;
    }
  </style>

{{-- Smartlook --}}
  @if(isset($smartlook) and $smartlook)
  <script type="text/javascript">
    window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', 'a64794367bb993b9b57aa2f94e7b6652e55827c2');
  </script>
  @endif

  {{-- Global site tag (gtag.js) - Google Analytics --}}
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115220710-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-115220710-1');
  </script>

   {{-- Facebook Pixel --}}
  @include('layouts.includes.js.pixels.facebook-pixel')
   
</head>
<body>
  @include('layouts.top')

  @yield('content')

  @include('layouts.includes.js.scripts')

  @show

  {{-- Offer Conversion: Perfilamento - Manaus --}}
  @if(session('idCustomer'))
    <img
      src="#"
      width="1"
      height="1"
    >
  @endif
</body>
</html>
