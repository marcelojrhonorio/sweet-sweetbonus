<!doctype html>
<html lang="en">
<head>
  {{-- Full History --}}
  <script>
      window['_fs_debug'] = false;
      window['_fs_host'] = 'fullstory.com';
      window['_fs_org'] = 'A71CT';
      window['_fs_namespace'] = 'FS';
      (function(m,n,e,t,l,o,g,y){
        if (e in m) {if(m.console && m.console.log) { m.console.log('FullStory namespace conflict. Please set window["_fs_namespace"].');} return;}
        g=m[e]=function(a,b){g.q?g.q.push([a,b]):g._api(a,b);};g.q=[];
        o=n.createElement(t);o.async=1;o.src='https://'+_fs_host+'/s/fs.js';
        y=n.getElementsByTagName(t)[0];y.parentNode.insertBefore(o,y);
        g.identify=function(i,v){g(l,{uid:i});if(v)g(l,v)};g.setUserVars=function(v){g(l,v)};
        y="rec";g.shutdown=function(i,v){g(y,!1)};g.restart=function(i,v){g(y,!0)};
        g.identifyAccount=function(i,v){o='account';v=v||{};v.acctId=i;g(o,v)};
        g.clearUserCookie=function(){};
      })(window,document,window['_fs_namespace'],'script','user');
  </script>
  {{-- Required meta tags --}}
  <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  {{-- Bootstrap CSS --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/clairvoyant/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/clairvoyant/css/animate.css') }}">

  {{-- Icon --}}
  <link rel="icon" href="{{ asset ('assets/clairvoyant/imgs/favicon.ico') }}" type="image/x-icon }}"/>
  <link rel="shortcut icon" href="{{ asset ('assets/clairvoyant/imgs/favicon.ico') }}" type="image/x-icon"/>

  {{-- Fonts --}}
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
  <title>Clairvoyant Club</title>
</head>
<body>

  {{-- Main --}}
  <section id="main">
    <div class="container">
      <div class="row logo">
        <div class="col-lg-6 wow fadeInUp">
          <h1><img src="{{ asset ('assets/clairvoyant/imgs/main-title.png')}}" title="Clairvoyant Club" alt="Clairvoyant Club" class="img-fluid"></h1>
          <h2>Clube de vantagens esotéricas <strong>especialmente</strong> para você!</h2>
        </div>
        <div class="col-lg-4 offset-lg-1 wow fadeInRight" id="form-box">
          <div class="title">
            <h3>Clairvoyant Club + Estrela Fone</h3>
            <p>Ganhe uma <span>vidência gratuita</span>.</p>
          </div>
          {{-- Form --}}
          <form method="post" action="{{ url('clairvoyant') }}" data-form-register>
            {!!csrf_field()!!}
            <input type="hidden" name="lp_offer_id" value="" /> 
            <input type="hidden" name="lp_campaign_id" value="" />
            <div class="alert alert-danger sr-only" data-form-register-alert>
              {{-- Form Register Feedback --}}
            </div>
            <!-- The rest of the fields name must match what you have set in the vertical -->   
            <!-- input type="hidden" name="lp_redirect_url" value="http://meu-novo-vw.com.br/sucesso.html" / --> 
            <!-- lp_redirect_url: Optional redirect url when the lead is accepted -->  
            <!--input type="hidden" name="tracking_id" value= "{{ session('hasoffersToken') }}" / -->
            <!-- lp_redirect_fail_url: Optional redirect url when the lead is rejected. -->
            <!-- input type="hidden" name="tracking_id2" value= "{{ session('beeleadsToken') }}" /-->
            <!-- lp_redirect_fail_url: Optional redirect url when the lead is rejected. -->            
            <div class="form-group">
              <label>Nome</label>
              <input id="first_name" type="text" class="form-control" name="first_name" required="required">
            </div>
            <div class="form-group">
              <label>E-mail</label>
              <input id="email_address" type="email" class="form-control" name="email_address" required="required">
            </div>
            <div class="form-group">
              <label>Data de Nascimento</label>
              <input id="birthdate" type="text" class="form-control" name="birthdate" required="required" data-mask-birthdate>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <label for="female">
                    <input id="female" name="gender" type="radio" value="female" required> Mulher
                  </label>
                </div>
                <div class="col">
                  <label for="male">
                    <input id="male" name="gender" type="radio" value="male" required> Homem
                  </label>
                </div>
              </div>             
            </div>         
            <div>
              <button type="submit" data-submit-button><span>Quero concorrer</span></button>
            </div>
          </div>
        </form>
        {{-- End Form --}}
      </div>
    </div>
  </div>

</section>
  {{-- End Main --}}


{{-- Footer --}}
<footer class="footer">
  <div class="container">
    <span>© 2018 Clairvoyant Club. Todos os direitos reservados
</footer>
{{-- End Footer --}}

@include('layouts.partials.modal-clairvoyant')

{{-- jQuery first, then Popper.js, then Bootstrap JS --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


{{-- Mask) --}}
<script src="{{ asset('assets/js/jquery.mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/clairvoyant/js/mask.js') }}"></script>

{{-- Wow --}}
<script src="{{ asset('assets/clairvoyant/js/wow.js') }}"></script>
<script type="text/javascript">
  new WOW().init();
</script>

</body>
</html>