@extends('layout.master')
@section('content')
<body class="bg-gray-200">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                  <div class="row">
                    <div class="col-2 text-center ms-auto">
                      <a class="btn btn-link" href="javascript:;">
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                @if(\Session::has('error'))
                  <div class="alert alert-danger alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{\Session::get('error')}}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                <form role="form" class="text-start" method="POST" action="{{route('login')}}">
                  @csrf
                  <label class="form-label">Email</label>
                  <div class="input-group input-group-outline mb-4">
                    <input type="email" class="form-control" name="email"  autocomplete="off" required >
                  </div>
                  <label class="form-label">Password</label>
                  <div class="input-group input-group-outline mb-4">
                    <input type="password" class="form-control" name="password" required>
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @endsection