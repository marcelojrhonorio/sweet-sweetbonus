<section id="main" class="main-xmove">
  <header style="background-color:#fff">
    <div class="container">
      <div class="row">
      <div class="col-md-7">
          <a href="#" title="XMove Car"><img src="{{ asset('images/subpage/xmove-car/xmovecar.png') }}" class="logo-xmove"></a>
         
        </div>
        <div class="col-md-5 menu menu-xmove">
          <ul id="top-menu">
            <li><a href="https://api.whatsapp.com/send?phone=5511940537841&text=Ol%C3%A1,%20gostaria%20de%20mais%20informações%20sobre%20aluguel%20de%20veículos" target="_blank" style="text-decoration:none;color:#989b9b;" title="Clique aqui e nos envie uma mensagem."><span style="color:#5e6363"> <i class="fab fa-whatsapp"></i> Whatsapp:</span> (11) 94053-7841</a></li>
            <li><strong style="color:#989b9b"><i class="far fa-calendar-check"></i> De 2ª a 6ª das 9h às 18h (exceto feriados)</strong></li>
            <li><a href="#about-xmove" style="color:#5e6363;text-decoration:none;"><strong>Sobre a empresa</strong></a></li>
            <li><a class="btn-xmove-car btn btn-outline-danger" href="#form-xmove"><strong>ALUGUE SEU CARRO</strong></a></li>
          </ul>            
        </div>                
      </div>
    </div>
  </header>    
  
  <div class="container">
    <div class="row">        
        <div class="col-lg-7">
            <h1>
              <ul class="text-xmove">
                <li><h2 style="color:#f33658"><strong>Alugue sem burocracia!</strong></h2></li>
                <li class="xmove-steps-mobile"><img src="{{ asset('images/subpage/xmove-car/main-number-1_grey.png') }}"> Planos de KM Limitado e Ilimitado</li>
                <li class="xmove-steps-mobile"><img src="{{ asset('images/subpage/xmove-car/main-number-2_grey.png') }}"> Aluguel sem burocracia, sem cartão de crédito</li>
                <li class="xmove-steps-mobile"><img src="{{ asset('images/subpage/xmove-car/main-number-3_grey.png') }}"> Temos a menor franquia do mercado</li>
                <li class="xmove-steps-mobile"><img src="{{ asset('images/subpage/xmove-car/main-number-4_grey.png') }}"> Assistência 24h e atendimento personalizado </li>
                <br>
                <li class="rental-rules"><p style="color:#f33658"><strong>Regras para locação</strong></p></li>
                <li class="xmove-rules"><i class="fas fa-check"></i><strong> &nbsp; Ter garagem </strong></li>
                <li class="xmove-rules"><i class="fas fa-check"></i><strong> &nbsp; CNH com menos de XX pontos e válida </strong></li>
                <li class="xmove-rules"><i class="fas fa-check"></i><strong> &nbsp; Não ter antecedentes criminais </strong></li>
                <li class="xmove-rules"><i class="fas fa-check"></i><strong> &nbsp; Estar cadastrado em apps de mobilidade </strong></li>
              </ul>
            </h1>
          </div>      

        {{-- Form --}}
        <div id="form-xmove" class="col-lg-5">
          <div class="form-box">
            <div class="form-top" id="form-top-xmove">
              <h3 style="font-size:120%" id="top-form-xmove">Receba o contato de um de nossos <br>consultores em poucos minutos.</h3>
            </div>

            <form method="post" action="{{ url('xmove-car') }}" data-form-xmove>
              <div class="row">
                <div class="col-12">
                  <div class="alert alert-danger sr-only" data-form-register-alert>
                    {{-- JavaScript shows validation feedback here --}}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-12">
                  <input id="site_origin" name="site_origin" type="hidden" value={{Request::url()}}>                  
                  <label for="name">Nome</label>
                  <input id="name" class="form-control" name="name" type="text" required placeholder="Ex: Nome Sobrenome" data-mask-name>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-12 mb-0">
                  <label for="email">E-mail</label>
                  <input id="email" class="form-control" name="email" type="email" placeholder="Ex: nome@gmail.com" required>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-12">
                  <label for="cell_phone">Celular</label>
                  <input id="cell_phone" class="form-control" name="cell_phone" type="text" placeholder="Ex: (XX) XXXXX-XXXX" data-cell-phone required>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-12">
                  <label for="phone">Outro telefone para contato</label>
                  <input id="phone" class="form-control" name="phone" type="text" placeholder="Ex: (XX) XXXXX-XXXX" data-phone>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="alert alert-danger sr-only" data-form-register-alert>
                    {{-- JavaScript shows validation feedback here --}}
                  </div>
                </div>              
              </div>

              <div class="row">
                <div class="col-12 col-centered">
                  <input type="hidden" value={{ env('STORE_URL') }} data-store-url>
                  <button class="submit-button btn-xmove" type="submit" data-form-button>
                    <span data-button-text>Quero saber mais <i class="fas fa-car-side" data-icon-car></i></span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        {{-- End Form --}}

      </div>
    </div>
</section>
<script src="{{ asset('js/sweet.js') }}"></script>
<script src="{{ asset('assets/xmove-car/js/xmovecar.js') }}" type="text/javascript"></script>
