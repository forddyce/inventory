@extends('app')

@section('title')
Laporan Laba Penjualan Klien - {{ config('app.name') }}
@stop

@section('content')
  <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-boxed">
    @include('include.header')
    @include('include.sidebar')

    <main id="main-container">
      <div class="content">
      </div>
    </main>

    @include('include.footer')
  </div>
@stop
