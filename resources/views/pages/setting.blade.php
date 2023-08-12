@extends('layout.master')
@section('content')
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Setting</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Setting</h6>
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
                  <form role="form" class="text-start" method="POST" action="{{route('update.setting')}}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="input-group input-group-outline my-3 is-filled" style="width:50%">
                        <label class="form-label" style="width:95%">Name</label>
                        <input type="text" class="form-control" name="name" required autocomplete="off" value="{{ \App\Models\Setting::where('name','name')->first()->value}}">
                      </div>
                      <div class="input-group input-group-outline my-3 is-filled" style="width:50%">
                        <label class="form-label" style="width:95%">Address</label>
                        <input type="text" class="form-control" name="address" required autocomplete="off" value="{{\App\Models\Setting::where('name','address')->first()->value}}">
                      </div>
                      <div class="input-group input-group-outline my-3 is-filled"style="width:50%" aria-autocomplete="off">
                        <label class="form-label" style="width:95%">Phone Number</label>
                        <input type="text" class="form-control" name="number" required value="{{\App\Models\Setting::where('name','number')->first()->value}}">
                      </div>
                      <div class="input-group input-group-outline my-3 is-filled"style="width:50%" aria-autocomplete="off">
                        <label class="form-label" style="width:95%">Side Bar Colour</label>
                        <select class="form-select form-control" aria-label="Default select example" name="sideBarColour">
                          @php
                            $sideBarColour = \App\Models\Setting::where('name','sideBarColour')->first()->value;
                          @endphp
                          <option value="Primary" @if($sideBarColour == "Primary") selected @endif>Primary</option>
                          <option value="Dark" @if($sideBarColour == "Dark") selected @endif>Dark</option>
                          <option value="Info" @if($sideBarColour == "Info") selected @endif>Info</option>
                          <option value="Success" @if($sideBarColour == "Success") selected @endif>Success</option>
                          <option value="Warning" @if($sideBarColour == "Warning") selected @endif>Warning</option>
                          <option value="Danger" @if($sideBarColour == "Danger") selected @endif>Danger</option>
                        </select>
                      </div>
                      <div class="input-group input-group-outline my-3 is-filled"style="width:50%" aria-autocomplete="off">
                        <label class="form-label" style="width:95%">Sidenav Type</label>
                        @php
                          $sidenavType = \App\Models\Setting::where('name','sidenavType')->first()->value;
                        @endphp
                        <select class="form-select form-control" aria-label="Default select example" name="sidenavType">
                          <option value="Dark" @if($sidenavType == "Dark") selected @endif>Dark</option>
                          <option value="Transparent" @if($sidenavType == "Transparent") selected @endif>Transparent</option>
                          <option value="White" @if($sidenavType == "White") selected @endif>White</option>
                        </select>
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Update Setting</button>
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
