@extends('layouts.omo')

@section('content')

  <div id="home" class="header-bgimage-2 bgimage-property clearfix">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 parent-mobile">
          <img src="assets/images/fundo.jpg" class="mobile"/>
        </div>
        <div class="col-sm-10 col-sm-offset-1 col-md-5 col-md-offset-1 header-div-right">
          <div class="form-section">
            <div class="header-div-right-title">
              <h1 class="main-title ganhe-desconto">Deixe suas roupas mais brancas!</h1>
              <p class="header-content">Cadastre-se e veja como receber o OMO grátis para testar em casa!</p>
            </div>
            <div class="row">
              <div class="form-col no-padding">
                <form class="contact-form-1" id="contact-form-1" method="post" action="#" accept-charset="UTF-8">
                  <div class="form-div">
                    <i class="fa fa-user"></i>
                    <input class="form-input" type="text" name="name" id="name" value="" placeholder="Nome" required maxlength="82" minlength="3" autocomplete="off">
                  </div>
                  <div class="form-div">
                    <i class="fa fa-envelope"></i>
                    <input class="form-input" type="email" name="email" id="email"  value="" placeholder="Email" required maxlength="120" autocomplete="off">
                  </div>
                  <div class="form-div">
                    <i class="fa fa-phone"></i>
                    <input class="form-input mask-phonecell" type="text" name="phone" id="phone" value="" placeholder="Telefone" required minlength="10" maxlength="15" autocomplete="off">
                  </div>
                  <div class="form-div" style="overflow: hidden;">
                    <div class="form-div-possui-cnpj col-xs-12">
                    <div style="margin-right:20px;"><input type="radio" name="gender" id="gender_f" value="F" checked/> Mulher</div><div><input type="radio" name="gender" id="gender_m" value="M"/> Homem</div></div>
                  </div>
                  <div class="form-div">
                    <i class="fa fa-calendar"></i>
                    <input class="form-input mask-data" type="text" name="birthdate" id="birthdate" value="" placeholder="Data de nascimento" required minlength="15" autocomplete="off">
                  </div>
                  <div class="form-div">
                    <i class="fa fa-map-marker"></i>
                    <input class="form-input mask-cep" type="text" name="cep" id="cep"  value="" placeholder="CEP" required minlength="15" autocomplete="off">
                  </div>
                  <div class="form-btn text-center">
                    <input type="submit" style="margin: auto;" class="btn btn-1 submit content-spacing content-bold"  name="create" id="create" value="Receber amostra">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')

  {{-- Google Code for Conversao_sweet Conversion Page
  In your html page, add the snippet and call
  goog_report_conversion when someone clicks on the
  chosen link or button. --}}
  <script type="text/javascript">
    /* <![CDATA[ */
    goog_snippet_vars = function() {
      var w = window;
      w.google_conversion_id = 815359827;
      w.google_conversion_label = "HCO1CIqCuH8Q087lhAM";
      w.google_remarketing_only = false;
    }
    // DO NOT CHANGE THE CODE BELOW.
    goog_report_conversion = function(url) {
      goog_snippet_vars();
      window.google_conversion_format = "3";
      var opt = new Object();
      opt.onload_callback = function() {
      if (typeof(url) != 'undefined') {
        window.location = url;
      }
    }
    var conv_handler = window['google_trackConversion'];
    if (typeof(conv_handler) == 'function') {
      conv_handler(opt);
    }
  }
  /* ]]> */
  </script>
  <script src="//www.googleadservices.com/pagead/conversion_async.js"></script>

  <script>
    (function ($) {
      $(function(event) {
        $('#create').on('click', goog_report_conversion);
      });
    })(jQuery);
  </script>

@endsection
