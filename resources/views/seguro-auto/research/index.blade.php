@extends('layouts.research')

@section('content')
<div class="form-header">
  <div class="title">
    <h1>Pesquisa Seguro Auto</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div id="app">
      <body-seguro></body-seguro>
    </div>
  </div>
</div>

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

@endsection