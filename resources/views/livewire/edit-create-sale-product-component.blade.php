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
                  
                  <div class="row">
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($name)) is-filled @endif">
                      <label class="form-label">Name</label>
                      <input type="text" class="form-control" name="name" wire:model.lazy="name" autocomplete="off">
                    </div>
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($heading1)) is-filled @endif">
                      <label class="form-label">Heading</label>
                      <input type="text" class="form-control" name="heading1" wire:model.lazy="heading1" autocomplete="off">
                    </div>
                  </div>

                  <div class="row">
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($text1)) is-filled @endif">
                      <label class="form-label">Text One</label>
                      <input type="text" class="form-control" name="text_1" wire:model.lazy="text1" autocomplete="off">
                    </div>
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($text2)) is-filled @endif">
                      <label class="form-label">Text Two</label>
                      <input type="text" class="form-control" name="text_2" wire:model.lazy="text2" autocomplete="off">
                    </div>
                  </div>

                  <div class="row">
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($text3)) is-filled @endif">
                      <label class="form-label">Text Three</label>
                      <input type="text" class="form-control" name="text_3" wire:model.lazy="text3" autocomplete="off">
                    </div>

                    <div class="form-check form-switch d-flex align-items-center ps-6 col-6">
                      <br>
                      <input class="form-check-input" type="checkbox" id="status" name="status" @if($isEnabled) checked @endif wire:model="isEnabled">
                      <label class="form-check-label mt-2" for="status">Status</label>
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
                  
                  <div class="row">
                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($salePrice)) is-filled @endif">
                      <label class="form-label">Sale Price</label>
                      <input type="number" class="form-control" name="salePrice" wire:model.lazy="salePrice" autocomplete="off">
                    </div>

                    <div class="input-group input-group-outline my-3 col-6 @if(!is_null($offerTillDate)) is-filled @endif">
                      <input type="datetime-local" id="datetime" name="offerTillDate" wire:model.lazy="offerTillDate">
                    </div>
                  </div>

                  <div class="input-group input-group-outline my-3 col-6">
                    @if ($image)
                      <img src="{{ $image->temporaryUrl() }}" width="150px" height="50px">
                    @elseif(!is_null($saleProduct))
                        <img src="{{ env('APP_URL').'storage/'.$saleProduct->image }}" width="150px" height="50px">
                    @endif
                  </div>      
                  <div class="col-6">
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

