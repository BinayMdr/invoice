@extends('layout.master')
@section('content')
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Branch</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">@if(!is_null($branch)) Update @else Add @endif Branch</h6>
        </nav>
      
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid px-2 px-md-4">
      <div class="card card-body mx-3">
        <div class="row">
          <div class="row">
            <div class="col-6">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <h6 class="mb-0">@if(!is_null($branch)) Update @else Add @endif Branch</h6>
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
                  @if(\Session::has('success'))
                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                      <span class="text-sm">{{\Session::get('success')}}</span>
                      <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  <form role="form" class="text-start" method="POST" @if(is_null($branch)) action="{{route('store.branch')}}" @else action="{{route('update.branch',['branch'=>$branch->id])}}" @endif>
                    @csrf
                    @if(!is_null($branch))
                      @method('PUT')
                    @endif
                    <div class="input-group input-group-outline my-3 @if(!is_null($branch)) is-filled @endif">
                      <label class="form-label">Branch Name</label>
                      <input type="text" class="form-control" name="name" required value="{{ $branch->name ?? ""}}" autocomplete="off">
                    </div>
                    <label class="form-check-label m-0" for="status">Status</label>
                    <div class="form-check form-switch d-flex align-items-center mb-3">
                      <br>
                      <input class="form-check-input" type="checkbox" id="status" name="status" @if(!is_null($branch) && $branch->is_enabled) checked @endif>
                    </div>
                    <label class="form-check-label m-0" for="status">Main branch</label>
                    <div class="form-check form-switch d-flex align-items-center mb-3">
                      <br>
                      <input class="form-check-input" type="checkbox" id="main_branch" name="main_branch" @if(!is_null($branch) && $branch->main_branch) checked @endif>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($branch)) Update @else Add @endif Branch</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('layout.footer')
    </div>
  </div>
@endsection
