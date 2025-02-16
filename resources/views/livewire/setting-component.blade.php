<div class="container-fluid px-2 px-md-4">
  <div class="card card-body mx-3">
    <div class="row">
      <div class="row">
        <div class="col-12">
          <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Update Settings </h6>
            </div>
            <div class="card-body">
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
              <form class="text-start" wire:submit.prevent="save" >  
              
                <div class="row mb-2">
                  
                  <div class="col-4">
                    <label class="form-label">Name</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="name" wire:model.lazy="name" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-4">
                    <label class="form-label">Email</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="email" wire:model.lazy="email" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-4">
                    <label class="form-label">Phone Number</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="number" wire:model.lazy="number" autocomplete="off" >
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4 mt-6">
                  
                  <div class="col-6">
                    <label class="form-label">Address</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="address" wire:model.lazy="address" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Google Map</label>
                    <div class="input-group input-group-outline">
                      <textarea type="text" style="resize: none;" class="form-control" name="googleMap" wire:model.lazy="googleMap" autocomplete="off" rows="3" style="resiez:none">{{$googleMap}}</textarea>
                    </div>
                  </div>

                 
                </div>

                <div class="row mt-6">

                  <div class="col-6">
                    <label class="form-label">Facebook Link</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="facebookLink" wire:model.lazy="facebookLink" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Tik Tok Link</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="tikTokLink" wire:model.lazy="tiktokLink" autocomplete="off">
                    </div>
                  </div>
                  
                </div>

                <div class="row mt-6">
                  
                  <div class="col-6">
                    <label class="form-label">Insta Link</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="instaLink" wire:model.lazy="instaLink" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Youtube Link</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="youtubeLink" wire:model.lazy="youtubeLink" autocomplete="off">
                    </div>
                  </div>
                </div>

                <div class="row mb-4 mt-6">
                  <div class="col-6">
                    <div class="my-4" style="width: 100%; height: 150px; overflow: hidden;">
                      @if ($tempBannerImage)
                        <img src="{{ $tempBannerImage->temporaryUrl() }}" width="100%" height="100%">
                      @elseif(count($settings) > 0)
                          <img src="{{ env('APP_URL').'storage/'.$settings['banner-image'] }}" width="100%" height="100%">
                      @endif
                    </div>      
                    <div>
                      <label class="form-label">Default Banner Image(Except Home Page)</label>
                      <input type="file" class="form-control" name="bannerImage" wire:model.lazy="tempBannerImage" accept="image/*">
                    </div> 
                  </div>

                  <div class="col-6">
                    <label class="form-label">Chat Script</label>
                    <div class="input-group input-group-outline">
                      <textarea type="text" style="resize: none;" class="form-control" name="chatScript" wire:model.lazy="chatScript" autocomplete="off" rows="12" style="resiez:none">{{$chatScript}}</textarea>
                    </div>
                  </div>


                </div>
                @if(\Auth::user()->hasRole('add-settings') || \Auth::user()->hasRole('edit-settings') )
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Update Settings</button>
                </div>
                @endif
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('layout.footer')
  
</div>

