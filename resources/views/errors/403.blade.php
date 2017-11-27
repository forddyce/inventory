@extends('app')

@section('title')
Page Forbidden - {{ config('app.name') }}
@stop

@section('content')
  <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-boxed">
    @include('include.header')
    @include('include.sidebar')

    <main id="main-container">
      <div class="hero bg-white">
        <div class="hero-inner">
          <div class="content content-full">
            <div class="py-30 text-center">
              <div class="display-3 text-danger">
                <i class="fa fa-warning"></i> 403
              </div>
              <h1 class="h2 font-w700 mt-30 mb-10">Oops.. You just found an error page..</h1>
              <h2 class="h3 font-w400 text-muted mb-50">We are sorry but the page you are looking for was not found..</h2>
              <a class="btn btn-hero btn-rounded btn-alt-secondary" href="{{ route('home') }}">
                <i class="fa fa-arrow-left mr-10"></i> Back to Home
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>

    @include('include.footer')
  </div>
@stop
