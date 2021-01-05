<form id="survey" data-form-register>
{{ csrf_field() }}
  <div class="section-title">
    <h3>Insira seus dados abaixo:</h3>
    <hr>
  </div>
  <div class="conditional-inputs">
    <div class="form-group">
      <div class="alert alert-danger sr-only" data-form-register-alert>
        {{-- JavaScript shows validation feedback here --}}
      </div>
    </div>    
    <div class="form-group">
      <input id="fullname" name="fullname" class="fullname" type="text" placeholder="Nome completo" required data-customer-fullname>
    </div>
    <div class="form-group">
      <p class="radio-label">
        <input class="gender" type="radio" id="homem" name="gender" value="M">
        <label for="homem">Homem</label>
        <input clas="gender" type="radio" id="mulher" name="gender" value="F">
        <label for="mulher">Mulher</label>
      </p>
    </div>
    <div class="form-group">
      <input id="phone_number" name="phone_number" class="phone_number" type="text" placeholder="DDD" size="2" required data-customer-ddd>
    </div>
    <div class="form-group">
      <input id="cep" name="cep" class="cep" type="text" placeholder="CEP" required data-customer-cep>
    </div>
    <div class="form-group">
      <input id="birthdate" name="birthdate" class="birthdate" type="text" placeholder="Data de nascimento" required data-customer-birthdate>
    </div>
    <div class="form-group">
      <input id="email" name="email" class="email" type="email" placeholder="E-mail" required data-customer-email>
    </div>
    <div class="form-group">
      <div class="alert alert-danger sr-only" data-form-register-alert>
        {{-- JavaScript shows validation feedback here --}}
      </div>
    </div>
  </div>
  <button class="btn-submit" type="submit">Enviar</button>
</form>