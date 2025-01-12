@extends('layout.master')
@section('content')
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Contact</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">@if(!is_null($contact)) Update @else Add @endif Contact</h6>
        </nav>
      
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid px-2 px-md-4">
      <div class="card card-body mx-3">
        <div class="row">
          <div class="row">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <h6 class="mb-0">@if(!is_null($contact)) Update Contact @else Add Contact @endif </h6>
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
                  <form role="form" class="text-start" method="POST" action="{{route('update.contacts')}}">
                    @csrf
                    @method('PUT')
                    <div class="row mb-4">
                      <div class="col-6">
                        <label class="form-label">Country</label>
                        <div class="input-group input-group-outline" >
                          <input type="text" class="form-control" name="country"  value="{{ $contact->country ?? ""}}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-6">
                        <label class="form-label">Address</label>
                        <div class="input-group input-group-outline">
                          <input type="text" class="form-control" name="address"  value="{{ $contact->address ?? ""}}" autocomplete="off">
                        </div>   
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-6">
                        <label class="form-label">Email</label>
                        <div class="input-group input-group-outline" >
                          <input type="email" class="form-control" name="email"  value="{{ $contact->email ?? ""}}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-6">
                        <label class="form-label">Number</label>
                        <div class="input-group input-group-outline">
                          <input type="text" class="form-control" name="number"  value="{{ $contact->number ?? ""}}" autocomplete="off">
                        </div>   
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($contact)) Update @else Add @endif Contact</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>
      @include('layout.footer')
    </div>
  </div>
@endsection
