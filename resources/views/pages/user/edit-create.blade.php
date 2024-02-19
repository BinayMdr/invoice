@extends('layout.master')
@section('content')
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">User</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">@if(!is_null($user)) Update @else Add @endif User</h6>
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
                  <h6 class="mb-0">@if(!is_null($user)) Update User @else Add User @endif </h6>
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
                  <form role="form" class="text-start" method="POST" @if(is_null($user)) action="{{route('store.user')}}" @else action="{{route('update.user',['user'=>$user->id])}}" @endif>
                    @csrf
                    @if(!is_null($user))
                      @method('PUT')
                    @endif
                    <div class="row">
                      <div class="input-group input-group-outline my-3 col-6 @if(!is_null($user)) is-filled @endif">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required value="{{ $user->name ?? ""}}" autocomplete="off" @if(!is_null($user)) readonly @endif>
                      </div>
                      <div class="input-group input-group-outline my-3 col-6 @if(!is_null($user)) is-filled @endif">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required value="{{ $user->email ?? ""}}" autocomplete="off" @if(!is_null($user)) readonly @endif>
                      </div>   
                    </div>
                    <div class="row"> 
                      <div class="input-group input-group-outline my-3 is-filled col-6" aria-autocomplete="off" >
                        <label class="form-label"  style="width:95%">Branch</label>
                        <select class="form-select form-control" aria-label="Default select example" name="group_id">
                          @foreach(\App\Models\Group::get() as $group)
                            <option value="{{$group->id}}" @if( $group->id == $user?->group_id ) selected @endif>{{$group?->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-check form-switch d-flex align-items-center ps-6 col-6">
                        <br>
                        <input class="form-check-input" type="checkbox" id="status" name="status" @if(!is_null($user) && $user->is_enabled) checked @endif>
                        <label class="form-check-label mt-2" for="status">Status</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-group input-group-outline my-3 col-6 @if(!is_null($user)) is-filled @endif">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" @if(is_null($user)) required @endif autocomplete="off">
                      </div>   
                      <div class="input-group input-group-outline my-3 col-6 @if(!is_null($user)) is-filled @endif">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" @if(is_null($user)) required @endif autocomplete="off">
                      </div>   
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($user)) Update @else Add @endif User</button>
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
