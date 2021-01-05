{{-- Main --}}
    <section id="main">
      <header>
        <div class="container">
          <div class="row">
            <div class="col-md-7">
              <a href="#" title="Sweet Bonus" class="logo"><img src="{{ asset('images/home/main-logo.png') }}"></a>
              @include('layouts.partials.hamburger-menu')
            </div>
            <div class="col-md-5 menu">
              <ul id="top-menu">
                <li><a href="https://sweetbonus.com.br/blog/">Blog</a></li>
                <li><a href="{{ env('STORE_URL') }}">Login</a></li>
              </ul>
            </div>
          </div>
        </div>
      </header>
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <h1>
              <ul>
                <li><img src="{{ asset('images/home/main-number-1.png') }}"> Entre na nossa <strong>comunidade</strong></li>
                <li><img src="{{ asset('images/home/main-number-2.png') }}"> Responda a <strong>pesquisas</strong></li>
                <li><img src="{{ asset('images/home/main-number-3.png') }}"> Ganhe <strong>pontos</strong></li>
                <li><img src="{{ asset('images/home/main-number-4.png') }}"> E troque por <strong>produtos </strong>   que receberá <span>gratuitamente</span> em casa</li>
              </ul>
            </h1>
            <img src="{{ asset('images/home/main-products.png') }}" class="products img-fluid">
          </div>

          {{-- Form --}}
          <div class="col-lg-5">
            <div class="form-box">
              <div class="form-top">
                <h3>Faça seu cadastro<br><span>Receba produtos gratuitamente em sua casa</span></h3>
              </div>

            <form method="post" action="{{ url('produtos') }}" data-form-register>
              <div class="row">
                <div class="col-12">
                  <div class="alert alert-danger sr-only" data-form-register-alert>
                    {{-- JavaScript shows validation feedback here --}}
                  </div>
                </div>
              </div>              

              <form method="post" action="https://neoleads.leadspediatrack.com/post.do" data-form-register>
                <input type="hidden" name="lp_offer_id" value="" />
                <input type="hidden" name="lp_campaign_id" value="" />
                {{-- The rest of the fields name must match what you have set in the vertical --}}
                <input type="hidden" name="lp_redirect_url" value="/sucesso.html" />
                {{-- lp_redirect_url: Optional redirect url when the lead is accepted --}}
                <input type="hidden" name="lp_redirect_fail_url" value="" />
                {{-- lp_redirect_fail_url: Optional redirect url when the lead is rejected. --}}

                <div class="row">
                  <div class="form-group col-12">
                    <input id="site_origin" name="site_origin" type="hidden" value={{Request::url()}}>                    
                    <label for="name">Nome</label>
                    <input id="name" class="form-control" name="name" type="text" required placeholder="Ex: Nome Sobrenome" data-mask-name>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-12">
                    <label for="email">E-mail</label>
                    <input id="email" class="form-control" name="email" type="email" placeholder="Ex: nome@gmail.com" required>
                  </div>
                </div>

                <div class="row">
                  <div class="radio col" required="required">
                    <label><input id="gender_f" name="gender" type="radio" value="F" required>Mulher</label>
                  </div>
                  <div class="radio col">
                    <label><input id="gender_m" name="gender" type="radio" value="M" required>Homem</label>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-12">
                    <label for="birthdate">Data de nascimento</label>
                    <input id="birthdate" class="form-control" name="birthdate" type="text" placeholder="Ex: DD/MM/AAAA" data-mask-date required>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-12">
                    <label for="cep">CEP</label>
                    <input id="cep" class="form-control" name="cep" type="text" pattern="[0-9]{2}[\.]?[0-9]{3}[\-]?[0-9]{3}" placeholder="Ex: 00000-000" data-mask-cep required>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-12">
                    <label><input id="privacy-and-conditions" name="privacy-and-conditions" type="checkbox" value="Sim" required> Aceito a <a href="{{ url('politica-de-privacidade-sweet') }}">politica de privacidade</a> e os <a href="{{ url('termos-e-condicoes') }}">termos e condições</a>.</label>
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
                    <button class="submit-button" type="submit" data-form-button><span data-button-text>Cadastre-se gratuitamente</span></button>
                  </div>
                </div>

              </form>

            </div>
          </div>
        {{-- End Form --}}
        </div>
      </div>
    </div>
</section>