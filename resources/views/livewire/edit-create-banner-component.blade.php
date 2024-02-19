<div class="container-fluid px-2 px-md-4">
    <div class="card card-body mx-3">
      <div class="row">
        <div class="row">
          <div class="col-12">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">@if(!is_null($banner)) Update banner @else Add banner @endif </h6>
              </div>
              <div class="card-body">
                @error('name')
                  <div class="alert alert-danger alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{ $message}}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
                @error('image')
                  <div class="alert alert-danger alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{ $message}}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
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
                  @if(!is_null($banner))
                      wire:submit.prevent="update" 
                  @else 
                      wire:submit.prevent="save" 
                  @endif>  
                  
                  <div class="row">
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($name)) is-filled @endif">
                      <label class="form-label">Name</label>
                      <input type="text" class="form-control" name="name" wire:model.lazy="name" autocomplete="off" @if(!is_null($banner)) readonly @endif>
                    </div>
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($text)) is-filled @endif">
                      <label class="form-label">Text</label>
                      <input type="text" class="form-control" name="text" wire:model.lazy="text" autocomplete="off">
                    </div>
                  </div>

                  <div class="row">
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($heading1)) is-filled @endif">
                      <label class="form-label">Heading One</label>
                      <input type="text" class="form-control" name="heading_1" wire:model.lazy="heading1" autocomplete="off">
                    </div>
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($heading2)) is-filled @endif">
                      <label class="form-label">Heading Two</label>
                      <input type="text" class="form-control" name="heading_2" wire:model.lazy="heading2" autocomplete="off">
                    </div>
                  </div>

                  <div class="row">
                   
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($buttonText)) is-filled @endif">
                      <label class="form-label">Button Text</label>
                      <input type="text" class="form-control" name="button_text" wire:model.lazy="buttonText" autocomplete="off">
                    </div>

                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($buttonLink)) is-filled @endif">
                      <label class="form-label">Button Link</label>
                      <input type="text" class="form-control" name="button_link" wire:model.lazy="buttonLink" autocomplete="off">
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($searchKey)) is-filled @endif">
                      <label class="form-label">Search Key</label>
                      <input type="text" class="form-control" name="search_key" wire:model.lazy="searchKey" autocomplete="off">
                    </div>
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($searchValue)) is-filled @endif">
                      <label class="form-label">Search Value</label>
                      <input type="text" class="form-control" name="search_value" wire:model.lazy="searchValue" autocomplete="off">
                    </div>
                  </div>

                  <div class="input-group input-group-outline my-3 col-6">
                    @if ($image)
                      <img src="{{ $image->temporaryUrl() }}" width="150px" height="50px">
                    @elseif(!is_null($banner))
                        <img src="{{ env('APP_URL').'storage/'.$banner->image }}" width="150px" height="50px">
                    @endif
                  </div>      
                  <div class="col-6">
                    <input type="file" class="form-control" name="image" wire:model.lazy="image">
                  </div>    
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($banner)) Update @else Add @endif Banner</button>
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

