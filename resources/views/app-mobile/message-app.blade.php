<!DOCTYPE html>
<html lang="pt-br">
<head>
{{-- Required meta tags --}}
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="language" content="pt-br" />

  <title> Redirecionamento </title>

  {{-- Fonts --}}
  <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  {{-- CSS --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="{{ asset('assets/researches/css/estilo.css')}}" type="text/css" rel="stylesheet">

  {{-- jQuery --}}
  <script type="text/javascript" src="{{ asset('assets/researches/js/jquery-1.11.0.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/researches/js/jquery.maskedinput.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/researches/js/formValidationBR.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/researches/js/jquery.jDiaporama.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/researches/js/script.js')}}"></script>  

  {{-- JS --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script type="text/javascript" src="{{ asset ('assets/researches/js/jquery.easing.min.js')}}"></script>

</head>
<body>

<input type="hidden" id="destination" name="destination" value="" data-redirect-address>

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
        @if(!(isset($data)))
            <h1>Em breve o app será liberado para você!</h1><br><br>
            <h4>A quantidade de downloads do app nesta fase de teste foi atingido, mas não se preocupe: <br> você pode entrar na lista de espera e logo poderá aproveitar esta novidade.</h4><br>
            <a style="color:#fff;text-decoration:none;border:ridge;padding:1%;" href="{{ env('APP_URL') }}/app-mobile/create-waiting-list/{{$customerId}}">ENTRAR NA LISTA DE ESPERA</a>
        @elseif(isset($data) && 'app_user_in_waiting_list' != $data)
            <h1>Em breve o app será liberado para você!</h1><br><br>
            <h4>Você foi inserido na lista de espera com sucesso. <br> Em breve poderá baixar o app e aproveitar as oportunidades da Sweet.</h4><br>
        @elseif('app_user_in_waiting_list' == $data)
            <h1>Em breve o app será liberado para você!</h1><br><br>
            <h4>Você já está adicionado na lista de espera. <br> Aguarde até que o download do app esteja disponível.</h4><br>
        @endif
      </div>
    </div>
  </div>
</div>
</body>
</html>
