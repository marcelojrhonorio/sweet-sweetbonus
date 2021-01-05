<!DOCTYPE html>
<html lang="pt-br">
<head>
{{-- Required meta tags --}}
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="language" content="pt-br" />

  <title> XMove Car </title>

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

<div style="background:#fff;" class="sucesso">
  <div style="color:#000;" class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
      <h3><strong>
            Obrigado, em breve entraremos em contato. </strong></h3>
          <br>
          <img src="{{ asset('images/subpage/xmove-car/xmovecar.png') }}" style="max-width: 180px;margin-top:-37px;" class="img-responsive img-final-xmove" alt="">
      
      </div>
    </div>
  </div>
</div>
</body>
</html>


