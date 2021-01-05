<div class="modal fade" tabindex="-1" role="dialog" data-sweet-modal>
  <div class="modal-dialog" role="document">
    <form method="post" action="{{ url('login') }}">
      {{ csrf_field() }}

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Já tem cadastro? Faça login aqui.
          </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="login_email">
              E-Mail
            </label>
            <input
              id="login_email"
              class="form-control"
              name="login_email"
              type="login_email"
              placeholder="Ex: seunome@gmail.com"
              data-login-email
            >
          </div>
          <div class="form-group">
            <label for="login_password">
              Senha
            </label>
            <input
              id="login_password"
              class="form-control"
              name="login_password"
              type="password"
              placeholder="Ex: ********"
              data-login-password
            >
          </div>
        </div>
        <div class="modal-footer">
          <a class="btn btn-link" href="http://store.sweetbonus.com.br/password/reset">
            Esqueceu a senha?
          </a>
          <button class="btn btn-success" type="submit">
            Login
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
