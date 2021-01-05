<!doctype html>
<html lang="pt-BR">
<head>
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

  <meta charset="utf-8">
  <meta name="description" content="OMO">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Sweet Bonus</title>

  <link rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  {{-- NIFTY MODALS --}}
  <link rel="stylesheet" href="assets/js/exit-intent/stick-to-me.css">

  <link rel="stylesheet" href="assets/css/style5.css?{{time()}}">

  <!--[if lt IE 9]>
  <script src="assets/js/html5shiv.js"></script>
  <script src="assets/js/respond.min.js"></script>
  <![endif]-->

  {{-- Global site tag (gtag.js) - Google Analytics --}}
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115220710-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-115220710-1');
  </script>

  {{-- Push notifications --}}
  <script charset="UTF-8" src="//cdn.sendpulse.com/9dae6d62c816560a842268bde2cd317d/js/push/63d97da3ef782eb28fa4a373d2f59084_0.js" async></script>

  <style>
    .level1 p.copyrights {
        font-size: 14px;
        text-align: center;
    }

    .copyrights a,
    .copyrights a:focus,
    .copyrights a:hover {
        color: #fff;
    }
    .copyrights a:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body class="theme">

  <header class="site-header">
    <div class="container">
      <a class="btn-login" href="#" data-trigger-login>
        Login
      </a>
    </div>
  </header>

  @yield('content')

  <footer class="copyright-1">
    <div class="container">
      <div class="assinatura">
        <div class="level1">
          <div class="">
            <p>Receba produtos grátis diretamente na sua casa para testar! Quer saber como? É muito simples! Basta preencher o formulário para fazer seu cadastro, responder as perguntas dos nossos patrocinadores e aguardar!</p>
            <br>

            <p class="title"><strong>- Preciso pagar alguma coisa?</strong></p>
            <p>Não! Todos os meses a SweetBonus escolherá pessoas que receberão amostras grátis em casa, até mesmo o envio(frete) para sua casa ficará por nossa conta!</p>

            <br><hr><br>

            <p class="title"><strong>- Posso receber produtos mesmo não sendo escolhido?</strong></p>
            <p>Sim, além das pessoas que são escolhidas! Acessando nossa página, você encontrará diversas atividades como: completar suas informações do perfil, compartilhar seu cadastro, visitar websites, responder a quizzes, compartilhar campanhas no Facebook, responder a pesquisas de opinião e muito mais.</p>

            <p>Ao concluir cada uma dessas tarefas, você ganha pontos que ficarão salvos com seu cadastro para que, posteriormente, você pode trocar por diversos produtos!</p>

            <br><hr><br>

            <p class="title"><strong>- O que posso ganhar?</strong></p>
            <p>Dependendo de sua quantidade de pontos, você pode trocar por produtos de marcas variadas como: Omo, Nutella, Dove e muito mais!</p>

            <br><hr><br>

            <p class="title"><strong>- O que é a Sweet?</strong></p>
            <p>A Sweet é uma plataforma em que qualquer pessoa pode realizar tarefas simples na internet, ganhar pontos e trocar por produtos.</p>

            <br><hr><br>

            <p class="copyrights">© {{ now()->year }} Sweet | <a class="footer-link" href="{{ url('termos-e-condicoes') }}">Termos e Condições</a> | <a class="footer-link" href="{{ url('politica-de-privacidade') }}">Política de Privacidade</a> | Todos os direitos reservados.</p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  @include('layouts.partials.modal')

  @include('layouts.includes.js.scripts')

  @show

</body>
</html>
