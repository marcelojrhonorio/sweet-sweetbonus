@extends('layouts.research')

@section('content')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
      <h2>@yield('title')</h2>
    </div>
  </div>
  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">

          <div class="ibox-content">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover content-table" style="width: 99%" data-result-table>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>nome</th>
                    <th>email</th>
                    <th>ddd</th>
                    <th>telefone</th>
                    <th>origem</th>
                    <th>resposta_api</th>
                    <th>data/hora</th>
                    <th>ação</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- JavaScript content --}}
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>nome</th>
                    <th>email</th>
                    <th>ddd</th>
                    <th>telefone</th>
                    <th>origem</th>
                    <th>resposta_api</th>
                    <th>data/hora</th>
                    <th>ação</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('customjs')
  <script src="{{ asset('assets/alfacon/js/alfacon-results.js') }}" type="text/javascript"></script>
  <script src="https://sweetmedia.com.br/assets/js/plugins/dataTables/datatables.min.js"></script>
@endsection