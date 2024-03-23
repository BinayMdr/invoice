<div class="container-fluid px-2 px-md-4">
    <div class="card card-body mx-3">
      <div class="row">
        <div class="row">
          <div class="col-12">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">@if(!is_null($saleProduct)) Update sale product @else Add sale product @endif </h6>
              </div>
              <div class="card-body">
                @error('name')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('image')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('offerTillDate')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('salePrice')
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
                  @if(!is_null($saleProduct))
                      wire:submit.prevent="update" 
                  @else 
                      wire:submit.prevent="save" 
                  @endif>  
                  
                  <div class="row mb-4">
                    <div class="col-6">
                      <label class="form-label">Name</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="name" wire:model.lazy="name" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Heading</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="heading1" wire:model.lazy="heading1" autocomplete="off">
                      </div>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-6">
                      <label class="form-label">Text One</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="text_1" wire:model.lazy="text1" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Text Two</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="text_2" wire:model.lazy="text2" autocomplete="off">
                      </div>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-6">
                      <label class="form-label">Text Three</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="text_3" wire:model.lazy="text3" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check form-switch d-flex align-items-center ps-6 mt-4">
                        <br>
                        <input class="form-check-input" type="checkbox" id="status" name="status" @if($isEnabled) checked @endif wire:model="isEnabled">
                        <label class="form-check-label mt-2" for="status">Status</label>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check form-switch d-flex align-items-center ps-6 mt-4">
                        <br>
                        <input class="form-check-input" type="checkbox" id="showSearch" name="showSearch" @if($showSearch) checked @endif wire:model="showSearch">
                        <label class="form-check-label mt-2 ms-2" for="showSearch">Show Search</label>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-6">
                      <label class="form-label">Button Text</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="button_text" wire:model.lazy="buttonText" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Button Link</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="button_link" wire:model.lazy="buttonLink" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="row mb-4">
                    <div class="col-6">
                      <label class="form-label">Search Key</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="search_key" wire:model.lazy="searchKey" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Search Value</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="search_value" wire:model.lazy="searchValue" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row mb-4">
                    <div class="col-6">
                      <label class="form-label">Sale Price</label>
                      <div class="input-group input-group-outline">
                        <input type="number" class="form-control" name="salePrice" wire:model.lazy="salePrice" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Offer Till Date</label>
                      <div class="input-group input-group-outline">
                        <input type="datetime-local" class="form-control" id="datetime" name="offerTillDate" wire:model.lazy="offerTillDate">
                      </div>
                    </div>
                  </div>

                  <div class="input-group input-group-outline col-6 mb-4 mt-2">
                    @if ($image)
                      <img src="{{ $image->temporaryUrl() }}" width="150px" height="100px" class="mb-4">
                    @elseif(!is_null($saleProduct))
                        <img src="{{ env('APP_URL').'storage/'.$saleProduct->image }}" width="150px" height="100px">
                    @endif
                  </div>      
                  <div class="col-6 pt-6">
                    <input type="file" class="form-control" name="image" wire:model.lazy="image">
                  </div>    
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($saleProduct)) Update @else Add @endif Sale Product</button>
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

