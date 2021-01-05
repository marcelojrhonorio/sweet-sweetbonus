<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="{{asset ('assets/login/css/style.css')}}">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body id="LoginForm">
    <div class="container">
      <div class="login-form">
        <div class="main-div">
          <div class="panel">
            <h2>Login Administrador</h2>
            <p>Por favor, entre com seu e-mail e senha</p>
          </div>
          <form id="login" method="post" action="/login">
            @if (session('alert'))
            <div class="alert alert-{{ session('alert.type') }}">
              {{ session('alert.message') }}
            </div>
            @endif
            <div class="form-group">
              <input id="email" name="email" type="email" class="form-control" placeholder="Endereço de e-mail" required>
            </div>
            <div class="form-group">
              <input id="password" name="password" type="password" class="form-control" placeholder="Senha" required>
            </div>
            <!--div class="forgot">
              <a href="reset.html">Forgot password?</a>
            </div-->
            <div>
              <input name="_token" type="hidden" value="{{ csrf_token() }}">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>