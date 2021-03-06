<section id="main">
  <header>
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <a href="#" title="Sweet Bonus" class="logo"><img src="{{ asset('images/subpage/main-logo.png') }}"></a>
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
            Receba produtos <span>gratuitamente</span><br>
            em sua casa
          </h1>
          <img src="{{ asset('images/subpage/main-bebes.png') }}" class="products img-fluid">
        </div>

        {{-- Form --}}
        <div class="col-lg-5">
          <div class="form-box">
            <div class="form-top">
              <h3>Sweet é 100% grátis. Participe! <span>Receba produtos gratuitamente em sua casa</span></h3>
            </div>

            <form method="post" action="{{ url('produtos') }}" data-form-register>
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
                <div class="radio col">
                  <label for="gender_f">
                    <input id="gender_f" name="gender" type="radio" value="F" required>Mulher
                  </label>
                </div>
                <div class="radio col">
                  <label for="gender_m">
                    <input id="gender_m" name="gender" type="radio" value="M" required>Homem
                  </label>
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
                  <input id="cep" class="form-control" name="cep" type="text" placeholder="Ex: 00000-000" data-mask-cep required>
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
                  <button class="submit-button" type="submit" data-form-button>
                    <span data-button-text>Receba amostras <i class="fas fa-gift"></i></span>
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