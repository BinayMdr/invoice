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
                  @if(!is_null($banner))
                      wire:submit.prevent="update" 
                  @else 
                      wire:submit.prevent="save" 
                  @endif>  
                  
                  <div class="row mb-4">
                    <div class="col-8">
                      <label class="form-label">Name <span class="text-danger">*</span> </label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="name" wire:model.lazy="name" autocomplete="off">
                      </div>
                    </div>
                    
                    <div class="col-4">
                      <label class="form-label">Order</label>
                      <div class="input-group input-group-outline">
                        <input type="number" class="form-control" name="order" min="1" wire:model.lazy="order" autocomplete="off">
                      </div>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-6">
                      <label class="form-label">Heading</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="heading" wire:model.lazy="heading" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Text</label>
                      <div class="input-group input-group-outline">
                        <textarea type="text" class="form-control" rows="3" style="resize:none" name="text" wire:model.lazy="text" autocomplete="off">{{$text}}</textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-4 mt-6">
                    <div class="col-4">
                      <label class="form-label">Button Text</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="button_text" wire:model.lazy="buttonText" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-4">
                      <label class="form-label">Button Link</label>
                      <div class="input-group input-group-outline ">
                        <input type="text" class="form-control" name="button_link" wire:model.lazy="buttonLink" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check form-switch d-flex align-items-center ps-6 mt-4">
                        <br>
                        <input class="form-check-input" type="checkbox" id="status" name="status" @if($isEnabled) checked @endif wire:model="isEnabled">
                        <label class="form-check-label mt-2 ms-2" for="status">Status</label>
                      </div>
                    </div>
                  </div>

                

                  <div class="row">
                    <div class="my-4" style="width: 100%; height: 150px; overflow: hidden;">
                      @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" style="width: 30%; height: 100%;">
                      @elseif(!is_null($banner))
                          <img src="{{ env('APP_URL').'storage/'.$banner->image }}" style="width: 30%; height: 100%;">
                      @endif
                    </div>      
                    <div>
                      <input type="file" class="form-control" name="image" wire:model.lazy="image" accept="image/*">
                    </div> 
                    <label class="form-label">Image @if(!$banner)<span class="text-danger">*</span> @endif</label>
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

