<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Seguro Auto - Informações</title>

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Oswald:600" rel="stylesheet">

  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/seguro-auto/css/style.css')  }}">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="//assets.bldstools.com/landings/?type=css" />
</head>

<body>
<div class="form-header">
  <div class="title">
    <h1>Pesquisa Seguro Auto - Informações Cadastrais</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div class="area-form">
      @if(Session::has('customer'))
        @include('seguro-auto.info.form-info-customer')
      @else
        @include('seguro-auto.info.form-info')
      @endif
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="{{ asset('assets/seguro-auto/js/insurance-info.js') }}" type="text/javascript"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="{{ asset('assets/js/laroute.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.mask/jquery.mask.min.js') }}"></script>
</body>
</html>