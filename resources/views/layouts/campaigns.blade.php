<!DOCTYPE html>
<html lang="pt-br">
  <head>
  
    <base href="/">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>:: Sweet Bonus ::</title>

    <meta name="title" content="Sweet Bonus: receba produtos gratuitamente em sua casa!">
    <meta name="description" content="A Sweet é uma plataforma em que qualquer pessoa pode realizar tarefas simples na internet, ganhar pontos e trocar por produtos.">
    <meta name="keywords" content="sweetbonus, testar, produtos, gratis">
    <link rel="icon" href="https://sweetbonus.com.br/images/subpage/favicon.ico" type="image/x-icon"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- End Bootstrap -->

    <link href="{{ asset('assets/css/new-campaigns.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.15.2/dist/sweetalert2.all.min.js"></script>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- Global site tag (gtag.js) - Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115220710-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-115220710-1');
    </script>

  </head>
  <body>

    @yield('content')
    
    {{-- Offer Conversion: Perfilamento - Manaus --}}
    @if(session('idCustomer'))
      <img
        src=#"
        width="1"
        height="1"
      >
    @endif

    @yield('scripts')

    <footer>
      <div class="container">
        <img src="https://sweetbonus.com.br/images/subpage/main-logo.png" style="width: 110px">
        <div class="link">
          <a href="{{ env('APP_URL') }}/politica-de-privacidade-sweet" target="_blank">Política de Privacidade</a> | <a href="{{ env('APP_URL') }}/termos-e-condicoes" target="_blank">Termos e Condições</a>
        </div>
        <div class="text">
          <div class="container">
            © Sweet Media Marketing Ltda - Todos os direitos reservados.<br>
          </div>
        </div>
      </div>
    </footer>
    
  </body>
</html>