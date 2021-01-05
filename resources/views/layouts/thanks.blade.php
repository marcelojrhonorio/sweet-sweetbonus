<!DOCTYPE html>
<html lang="pt-br">
<head>

  {{-- Full History --}}
  <script>
  window['_fs_debug'] = false;
  window['_fs_host'] = 'fullstory.com';
  window['_fs_org'] = 'CSWG1';
  window['_fs_namespace'] = 'FS';
  (function(m,n,e,t,l,o,g,y){
      if (e in m) {if(m.console && m.console.log) { m.console.log('FullStory namespace conflict. Please set window["_fs_namespace"].');} return;}
      g=m[e]=function(a,b,s){g.q?g.q.push([a,b,s]):g._api(a,b,s);};g.q=[];
      o=n.createElement(t);o.async=1;o.src='https://'+_fs_host+'/s/fs.js';
      y=n.getElementsByTagName(t)[0];y.parentNode.insertBefore(o,y);
      g.identify=function(i,v,s){g(l,{uid:i},s);if(v)g(l,v,s)};g.setUserVars=function(v,s){g(l,v,s)};g.event=function(i,v,s){g('event',{n:i,p:v},s)};
      g.shutdown=function(){g("rec",!1)};g.restart=function(){g("rec",!0)};
      g.consent=function(a){g("consent",!arguments.length||a)};
      g.identifyAccount=function(i,v){o='account';v=v||{};v.acctId=i;g(o,v)};
      g.clearUserCookie=function(){};
  })(window,document,window['_fs_namespace'],'script','user');
  </script>

  {{-- Required meta tags --}}
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="language" content="pt-br" />

  <title> Obrigado! </title>

  {{-- Fonts --}}
  <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  {{-- CSS --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="{{ asset('assets/thanks/css/estilo.css')}}" type="text/css" rel="stylesheet">

  {{-- jQuery --}}
  <script type="text/javascript" src="{{ asset('assets/thanks/js/jquery-1.11.0.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/thanks/js/jquery.maskedinput.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/thanks/js/formValidationBR.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/thanks/js/jquery.jDiaporama.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/thanks/js/script.js')}}"></script>  

  {{-- JS --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script type="text/javascript" src="{{ asset ('assets/thanks/js/jquery.easing.min.js')}}"></script>

</head>
<body>
 
 @yield('content')

</body>
</html>