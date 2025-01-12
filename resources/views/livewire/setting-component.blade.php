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
              
                <div class="row mb-4">
                  
                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="name" wire:model.lazy="name" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Top Text</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="topText" wire:model.lazy="topText" autocomplete="off" >
                    </div>
                  </div>

                </div>
                
                <div class="row mb-6">
                  <div class="col-6">
                    <div class="my-4" style="width: 100%; height: 150px; overflow: hidden;">
                      @if ($tempBannerImage)
                        <img src="{{ $tempBannerImage->temporaryUrl() }}" width="100%" height="100%">
                      @elseif(count($settings) > 0)
                          <img src="{{ env('APP_URL').'storage/'.$settings['banner-image'] }}" width="100%" height="100%">
                      @endif
                    </div>      
                    <div>
                      <label class="form-label">Top Banner</label>
                      <input type="file" class="form-control" name="topBanner" wire:model.lazy="tempBannerImage">
                    </div> 
                  </div>
                  <div class="col-6">
                    <div class="my-4" style="width: 100%; height: 150px; overflow: hidden;">
                      @if ($tempFooterImage)
                        <img src="{{ $tempFooterImage->temporaryUrl() }}" width="100%" height="100%">
                      @elseif(count($settings) > 0)
                          <img src="{{ env('APP_URL').'storage/'.$settings['footer-image'] }}" width="100%" height="100%">
                      @endif
                    </div>      
                    <div>
                      <label class="form-label">Footer Image</label>
                      <input type="file" class="form-control" name="footerImage" wire:model.lazy="tempFooterImage">
                    </div> 
                  </div>
                </div>

                <div class="row mb-6">
                  
                  <div class="col-6">
                    <label class="form-label">Footer Heading</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="footerHeading" wire:model.lazy="footerHeading" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Footer Placeholder</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="footerPlaceholder" wire:model.lazy="footerPlaceholder" autocomplete="off">
                    </div>
                  </div>

                </div>

                <div class="row mb-6">
                  
                  <div class="col-6">
                    <label class="form-label">Footer Text</label>
                    <div class="input-group input-group-outline">
                      <textarea type="text" class="form-control" name="footerText" wire:model.lazy="footerText" autocomplete="off" rows="3" style="resiez:none">{{$footerText}}</textarea>
                    </div>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Footer Slogan</label>
                    <div class="input-group input-group-outline">
                      <textarea type="text" class="form-control" name="footerSlogan" wire:model.lazy="footerSlogan" autocomplete="off" rows="3" style="resiez:none">{{$footerSlogan}}</textarea>
                    </div>
                  </div>

                </div>

                <div class="row mb-6">
                 
                  <div class="col-6">
                    <label class="form-label">Filter Tag</label>
                    <div class="input-group input-group-outline" aria-autocomplete="off" >
                      <select class="form-select form-control" aria-label="Default select example" name="filter_tag_id" wire:model="filterTag">
                        <option value="1" @if( $filterTag == "1" ) selected @endif>1</option>
                        <option value="2" @if( $filterTag == "2" ) selected @endif>2</option>
                        <option value="3" @if( $filterTag == "3" ) selected @endif>3</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Filter Product</label>
                    <div class="input-group input-group-outline" aria-autocomplete="off" >
                      <select class="form-select form-control" aria-label="Default select example" name="filter_product_id" wire:model="filterProduct">
                        <option value="1" @if( $filterTag == "1" ) selected @endif>1</option>
                        <option value="2" @if( $filterTag == "2" ) selected @endif>2</option>
                        <option value="3" @if( $filterTag == "3" ) selected @endif>3</option>
                        <option value="4" @if( $filterTag == "4" ) selected @endif>4</option>
                        <option value="5" @if( $filterTag == "5" ) selected @endif>5</option>
                        <option value="6" @if( $filterTag == "6" ) selected @endif>6</option>
                        <option value="7" @if( $filterTag == "7" ) selected @endif>7</option>
                        <option value="8" @if( $filterTag == "8" ) selected @endif>8</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row mb-6">
                 
                  <div class="col-6">
                    <label class="form-label">Related Product</label>
                    <div class="input-group input-group-outline" aria-autocomplete="off" >
                      <select class="form-select form-control" aria-label="Default select example" name="related_product_id" wire:model="relatedProduct">
                        <option value="Category" @if( $filterTag == "Category" ) selected @endif>Category</option>
                        <option value="Brand" @if( $filterTag == "Brand" ) selected @endif>Brand</option>
                        <option value="Tag" @if( $filterTag == "Tag" ) selected @endif>Tag</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-6">
                    <label class="form-label">Facebook Link</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="fbLink" wire:model.lazy="fbLink" autocomplete="off">
                    </div>
                  </div>
                 
                </div>

                <div class="row mb-6">

                  <div class="col-4">
                    <label class="form-label">Tik Tok Link</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="tikTokLink" wire:model.lazy="tiktokLink" autocomplete="off">
                    </div>
                  </div>
                  
                  <div class="col-4">
                    <label class="form-label">Pinterest Link</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="pinterestLink" wire:model.lazy="pinterestLink" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-4">
                    <label class="form-label">Insta Link</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="instaLink" wire:model.lazy="instaLink" autocomplete="off">
                    </div>
                  </div>
                </div>


                <div class="row mb-4">
                  <div class="col-6">
                    <div class="my-4" style="width: 100%; height: 150px; overflow: hidden;">
                      @if ($tempLoadingImage)
                        <img src="{{ $tempLoadingImage->temporaryUrl() }}" width="100%" height="100%">
                      @elseif(count($settings) > 0)
                          <img src="{{ env('APP_URL').'storage/'.$settings['loading-image'] }}" width="100%" height="100%">
                      @endif
                    </div>      
                    <div>
                      <label class="form-label">Loading Image</label>
                      <input type="file" class="form-control" name="loadingImage" wire:model.lazy="tempLoadingImage">
                    </div> 
                  </div>

                  <div class="col-6">
                    <label class="form-label">Chat Script</label>
                    <div class="input-group input-group-outline">
                      <textarea type="text" class="form-control" name="chatScript" wire:model.lazy="chatScript" autocomplete="off" rows="12" style="resiez:none">{{$footerSlogan}}</textarea>
                    </div>
                  </div>


                </div>

                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Update Settings</button>
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

