<div class="container-fluid px-2 px-md-4">
    <div class="card card-body mx-3">
      <div class="row">
        <div class="row">
          <div class="col-12">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">@if(!is_null($footerMenu)) Update footer menu @else Add footer menu @endif </h6>
              </div>
              <div class="card-body">
                @error('name')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('image')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @if($error)
                <div class="alert alert-danger alert-dismissible text-white" role="alert">
                  <span class="text-sm">{{ $error}}</span>
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
                <form class="text-start" 
                  @if(!is_null($footerMenu))
                      wire:submit.prevent="update" 
                  @else 
                      wire:submit.prevent="save" 
                  @endif>  
                  
                  <div class="row">
                    <label class="form-label">Name</label>
                    <div class="input-group input-group-outline col-6">
                      <input type="text" class="form-control" name="name" wire:model.lazy="name" autocomplete="off">
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-info" wire:click="addSubMenu"> Add Sub Menu</button>
                    </div>
                  </div>
                  @if(!is_null($subMenus))
                    @foreach($subMenus as $count => $subMenu )
                      <div class="row">
                        <div class="col-6">
                          <label class="form-label">Name</label>
                          <div class="input-group input-group-outline">
                            <input type="text" class="form-control" name="subMenu"  autocomplete="off" wire:change="updateSubMenu($event.target.value, {{$count}},'name')" value={{$subMenu['name']}}>
                          </div>
                        </div>
                        <div class="col-6">
                          <label class="form-label">Link</label>
                          <div class="input-group input-group-outline">
                            <input type="text" class="form-control" name="subMenuLink"  autocomplete="off" wire:change="updateSubMenu($event.target.value, {{$count}},'link')" value={{$subMenu['link']}}>
                          </div>
                        </div>
                      </div>
                      <div class="row my-3">
                        <div class="col-4">
                          <label class="form-label">Search Key</label>
                          <div class="input-group input-group-outline">
                            <input type="text" class="form-control" name="searchKey"  autocomplete="off" wire:change="updateSubMenu($event.target.value, {{$count}},'searchKey')" value={{$subMenu['searchKey']}}> 
                          </div>
                        </div>
                        <div class="col-3">
                          <label class="form-label">Seach Value</label>
                          <div class="input-group input-group-outline">
                            <input type="text" class="form-control" name="searchValue"  autocomplete="off" wire:change="updateSubMenu($event.target.value, {{$count}},'searchValue')" value={{$subMenu['searchValue']}}>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="form-check form-switch d-flex align-items-center ps-6 mt-4">
                            <br>
                            <input class="form-check-input" type="checkbox" id="showSearch" name="showSearch" @if($subMenu['showSearch'] == "1" || $subMenu['showSearch'] == true) checked @endif wire:change="updateSubMenu($event.target.value, {{$count}},'showSearch')">
                            <label class="form-check-label mt-2 ms-2" for="showSearch">Show Search</label>
                          </div>
                        </div>
                        <div class="col-2">
                          <button type="button" class="btn btn-danger w-100 my-4 mb-2" wire:click="deleteSubMenu({{$count}})">Delete</button>
                        </div>
                      </div>
                    @endforeach
                  @endif
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($footerMenu)) Update @else Add @endif Footer Menu</button>
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

