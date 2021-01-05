@extends('layouts.research')

@section('content')

<div class="form-header">
  <div class="title">
    <h1>Pesquisa sobre a relação entre carreira e ensino superior no Brasil.</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div id="app">
      <body-ead></body-ead>
    </div>
  </div>
</div>

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

@endsection