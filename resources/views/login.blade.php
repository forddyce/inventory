@extends('app')

@section('title')
Login - {{ config('app.name') }}
@stop

@section('content')
<div id="page-container" class="main-content-boxed">
  <main id="main-container"><div class="bg-gd-dusk">
    <div class="hero-static content content-full bg-white invisible" data-toggle="appear">
      <div class="py-30 px-5 text-center">
        <a class="link-effect font-w700" href="#">
          <i class="si si-organization"></i>
          <span class="font-size-xl text-primary-dark">System</span>&nbsp;<span class="font-size-xl">Inventory</span>
        </a>
        <h1 class="h2 font-w700 mt-50 mb-10">Selamat datang di dashboard</h1>
        <h2 class="h4 font-w400 text-muted mb-0">Mohon login terlebih dahulu</h2>
      </div>
      <div class="row justify-content-center px-5">
        <div class="col-sm-8 col-md-6 col-xl-4">
          <form class="action-form" http-type="post" data-url="{{ route('login.post') }}" onsubmit="return false;" method="post">
            <div class="form-group">
              <div class="form-material floating">
                <input type="email" class="form-control" id="email" name="email" required="">
                <label for="email">Email</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-material floating">
                <input type="password" class="form-control" id="password" name="password" required="">
                <label for="password">Password</label>
              </div>
            </div>
            <div class="form-group row gutters-tiny">
              <div class="col-12 mb-10">
                <button type="submit" class="ladda-button btn btn-block btn-hero btn-noborder btn-rounded btn-alt-primary" data-style="expand-left" data-toggle="click-ripple">
                  <i class="si si-login mr-10"></i> Sign In
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
</div
@stop