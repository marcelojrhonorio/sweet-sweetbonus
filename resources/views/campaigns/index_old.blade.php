@extends('layouts.campaigns')

@section('content')
  <div class="container text-center">
    <div class="row">
      <div class="col-md-12 text-center text-white">
        <h3>
          <strong>O SweetBonus escolhe pessoas reais para testar amostra, por isso responda com atenção as perguntas abaixo.</strong>
        </h3>
      </div>
    </div>

    <br><br>

    <div class="row"><br>
      <div class="col-md-12">
        <div class="progress2">
          <div class="zero no-color" id="zero"><span class="text-progress">0%</span></div>
          <div class="twenty-five no-color" id="twenty-five"><span class="text-progress">25%</span></div>
          <div class="fifty no-color" id="fifty"><span class="text-progress">50%</span></div>
          <div class="seventy-five no-color" id="seventy-five"><span class="text-progress">75%</span></div>
          <div class="hundred no-color" id="hundred"><span class="text-progress">100%</span></div>
          <div class="progress-bar progress-bar-warning" style="width: 0%"></div>
        </div>
      </div>
    </div>

    <br><br>

    <input type="hidden" value={{ Session::get('idCustomer') }} data-customer-id>

    <div class="row">
      <div class="col-md-12 text-center">
        <form action="" method="post">
          <input type="hidden" name="campaigns-total" id="campaigns-total" value="">
          <input type="hidden" name="domain" id="domain" value="{{ env('APP_STORAGE') }}">
          <ul id="slider"></ul>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  {{-- Google Code for Conversao_sweet Conversion Page --}}
  <script>
    /* <![CDATA[ */
    var google_conversion_id = 815359827;
    var google_conversion_label = "HCO1CIqCuH8Q087lhAM";
    var google_remarketing_only = false;
    /* ]]> */
  </script>
  <script src="//www.googleadservices.com/pagead/conversion.js"></script>
  <noscript>
    <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/815359827/?label=HCO1CIqCuH8Q087lhAM&amp;guid=ON&amp;script=0">
    </div>
  </noscript>

  <script src="assets/js/app/campaigns.js?{{time()}}"></script>
@endsection
