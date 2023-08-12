@extends('layout.master')
@section('content')
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Customer</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">@if(!is_null($customer)) Update @else Add @endif Customer</h6>
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
                  <h6 class="mb-0">@if(!is_null($customer)) Update @else Add @endif Customer</h6>
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
                  <form role="form" class="text-start" method="POST" @if(is_null($customer)) action="{{route('store.customer')}}" @else action="{{route('update.customer',['customer'=>$customer->id])}}" @endif>
                    @csrf
                    @if(!is_null($customer))
                      @method('PUT')
                    @endif
                    <div class="input-group input-group-outline my-3 @if(!is_null($customer)) is-filled @endif">
                      <label class="form-label">Customer Name</label>
                      <input type="text" class="form-control" name="name" required value="{{ $customer->name ?? ""}}" autocomplete="off">
                    </div>
                    <div class="input-group input-group-outline my-3 @if(!is_null($customer)) is-filled @endif">
                      <label class="form-label">Phone Number</label>
                      <input type="text" class="form-control" name="phone_number" required value="{{ $customer->phone_number ?? ""}}" autocomplete="off">
                    </div>   
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($customer)) Update @else Add @endif Customer</button>
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
