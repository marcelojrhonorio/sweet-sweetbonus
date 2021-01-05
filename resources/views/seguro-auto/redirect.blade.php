@extends('layouts.research-redirect')

@section('content')
<input type="hidden" id="destination" name="destination" value="{{ $data['redirect_link'] }}" data-redirect-address>
<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
        <h2 class="want-titulo" data-redirect-title> {{ $data['title'] }} </h2><br>
        <h3 data-redirect-subtitle> {{ $data['subtitle'] }} </h3><br>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="{{ asset('assets/seguro-auto/js/step-one.js') }}"></script>
@endsection