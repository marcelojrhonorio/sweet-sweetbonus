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
        <h3>Pesquisa concluída. Veja super promoções para seu perfil! </h3>
        <hr>
      </div>
      @if('SP' == Session::get('state'))
        <div class="img-wrap">
          <a href="http://ad.trackinng.com.br/aff_c?offer_id=66&aff_id=1209&file_id=925" target="_blank">
            <img class="banner" src="{{ asset('assets/seguro-auto/imgs/banner-cnh-cassada.png') }}" alt="CNH Cassada">
          </a>
        </div>
      @endif
      <div class="img-wrap sr-only">
        <a href="#">
          <img class="banner" src="{{ asset('assets/seguro-auto/imgs/banner-test-drive.png') }}" alt="Test Drive">
        </a>
      </div>
      <div class="img-wrap">
        <a href="https://contaconversao.com/tracker/track/BWCSCST?redirect=http%3A%2F%2Fwww.melhoreservicos.com.br%2F%3Futm_source%3Dleadsolution%26utm_medium%3Dcpl%26utm_campaign%3DBWCSCST%26source%3DBWCSCST" target="_blank">
          <img class="banner" src="{{ asset('assets/seguro-auto/imgs/banner-rastreador.png') }}" alt="Rastreador">
        </a>
      </div>
    </div>
  </div>
</div>

@endsection