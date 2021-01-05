@extends('layouts.research-redirect')

@section('content')

@php
  if(isset($redirect) && $redirect) {
    $redirect = $redirect;
  } else {
    $redirect = '';
  }
@endphp

<input type="hidden" id="destination" name="destination" value="{{ $redirect }}" data-redirect-address>

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
      <h2 class="want-titulo"><strong>
            @if(isset($middle_title) && $middle_title)
                {!! $middle_title !!}<br></strong></h2>  
                <h3>
                {!! $middle_description !!}      
                </h3>
            <br>
            <img src="{{ env('APP_STORAGE') }}/storage/{{ $image_path }}" class="img-responsive" alt="">
            @else
                Pesquisa finalizada!<br></strong></h3>  
                <h4>
                Obrigado pela participação.     
                </h4>
            @endif
          
      </div>
    </div>
  </div>
</div>

@endsection