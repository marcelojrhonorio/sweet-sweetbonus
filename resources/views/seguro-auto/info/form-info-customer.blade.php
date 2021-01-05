<form id="survey" data-form-register>
{{ csrf_field() }}
  <div class="section-title">
    <h3>Altere e/ou confirme seus dados abaixo:</h3>
    <hr>
  </div>
  <div class="conditional-inputs">
  <input id="customer_id" name="customer_id" class="customer_id" type="hidden" value="{{ Session::get('customer.id')}}" required data-customer-id>
    <div class="form-group">
      <div class="alert alert-danger sr-only" data-form-register-alert>
        {{-- JavaScript shows validation feedback here --}}
      </div>
    </div>
    <div class="form-group">
      <input id="fullname" name="fullname" class="fullname" type="text" placeholder="Nome completo" value="{{ Session::get('customer.fullname')}}" required data-customer-fullname>
    </div>
    <div class="form-group">
      <p class="radio-label">
        @if('M' === Session::get('customer.gender'))
          <input type="radio" id="homem" name="gender" class="gender" value="M" checked>
        @else
          <input type="radio" id="homem" name="gender" class="gender" value="M">
        @endif
        <label for="homem">Homem</label>
        @if('F' === Session::get('customer.gender'))
          <input type="radio" id="mulher" name="gender" class="gender" value="F" checked>
        @else
          <input type="radio" id="mulher" name="gender" class="gender" value="F">
        @endif
        <label for="mulher">Mulher</label>
      </p>
    </div>
    <div class="form-group">
      <input id="cep" name="cep" class="cep" type="text" placeholder="CEP" value="{{ Session::get('customer.cep')}}" required data-customer-cep>
    </div>
    <div class="form-group">
      <input readonly id="birthdate" name="birthdate" class="birthdate" type="text" placeholder="Data de nascimento" value="{{ Session::get('customer.birthdate')}}" required data-customer-birthdate>
    </div>
    <div class="form-group">
      <input readonly id="email" name="email" class="email" type="email" placeholder="E-mail" value="{{ Session::get('customer.email')}}" required data-customer-email>
    </div>
    <div class="form-group">
      <div class="alert alert-danger sr-only" data-form-register-alert>
        {{-- JavaScript shows validation feedback here --}}
      </div>
    </div>
  </div>
  <button class="btn-submit" type="submit">Enviar</button>
</form>