@extends('layouts.research')

@section('content')
<div class="form-header">
  <div class="title">
    <h1>Pesquisa Seguro Auto</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div class="area-form">
      {{ csrf_field() }}
      <div class="section-title">
        <h3>Pesquisa concluída! Estamos redirecionando para Store...</h3>
        <hr>
      </div>
      <input id="destination" class="destination" name="destination" type="hidden" value="{{ env('STORE_URL') }}" data-final-destination>
    </div>
  </div>
</div>

<script src="{{ asset('assets/seguro-auto/js/redirect.js') }}" type="text/javascript"></script>

@endsection