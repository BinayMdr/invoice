@extends('layout.master')
@section('content')
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Global Setting</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Global Setting</h6>
        </nav>

      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid px-2 px-md-4">
      <div class="card card-body mx-3">
        <div class="row">
              <div class="card card-plain h-100">
                <div class="card-body">
                  @if(\Session::has('error'))
                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                      <span class="text-sm">{{\Session::get('error')}}</span>
                      <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  @if(\Session::has('success'))
                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                      <span class="text-sm">{{\Session::get('success')}}</span>
                      <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  <form role="form" class="text-start" method="POST" action="{{route('update.global-setting')}}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="input-group input-group-outline my-3 is-filled" style="width:50%">
                        <label class="form-label" style="width:95%">PAN</label>
                        <input type="text" class="form-control" name="pan" required autocomplete="off" value="{{ \App\Models\GlobalSetting::where('name','pan')->first()->value ?? ""}}">
                      </div>
                      <div class="input-group input-group-outline my-3 is-filled" style="width:50%">
                        <label class="form-label" style="width:95%">Inventory Request Time</label>
                        <input type="time" class="form-control" name="inventory_request_time" required autocomplete="off" value="{{\App\Models\GlobalSetting::where('name','inventory_request_time')->first()->value ?? ""}}">
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Update Global Setting</button>
                    </div>
                  </form>
                </div>
              </div>
          </div>
      </div>
      @include('layout.footer')
    </div>
  </div>
@endsection