@extends('layouts.research')

@section('content')

<div class="form-header">
  <div class="title">
    <h1>Quiz portal de produtos</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div id="app">
      @if(1 === $id)
      <body-quiz></body-quiz>
      @elseif(2 === $id)
      <body-quiz2></body-quiz2>
      @else
      <body-quiz3></body-quiz3>
      @endif
    </div>
  </div>
</div>

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

@endsection