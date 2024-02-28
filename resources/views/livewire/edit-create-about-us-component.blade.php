<div class="container-fluid px-2 px-md-4">
    <div class="card card-body mx-3">
      <div class="row">
        <div class="row">
          <div class="col-12">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">@if(!is_null($aboutUs)) Update banner @else Add AboutUs @endif </h6>
              </div>
              <div class="card-body">
                @error('heading1')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('heading2')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('heading3')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('text1')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('text2')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('text3')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('topBanner')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @error('showLowerBanner')
                  @include('partials.error_alert', ['message' => $message])
                @enderror
                @if(\Session::has('success'))
                  <div class="alert alert-success alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{\Session::get('success')}}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                <form class="text-start" wire:submit.prevent="save" >  
                

                  <div class="row mb-6">
                    <div class="col-6">
                      <label class="form-label">Heading One</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="heading_1" wire:model.lazy="heading1" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Text One</label>
                      <div class="input-group input-group-outline">
                        <textarea type="text" class="form-control" style="resize:none" name="text_1" wire:model.lazy="text1" autocomplete="off" rows="3">{{$text1}}</textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-6">
                    <div class="col-6">
                      <label class="form-label">Heading Two</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="heading_2" wire:model.lazy="heading2" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Text Two</label>
                      <div class="input-group input-group-outline">
                        <textarea type="text" class="form-control" style="resize:none" name="text_2" wire:model.lazy="text2" autocomplete="off" rows="3">{{$text2}}</textarea>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row mb-6">
                    <div class="col-6">
                      <label class="form-label">Heading Three</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="heading_3" wire:model.lazy="heading3" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Text Three</label>
                      <div class="input-group input-group-outline">
                        <textarea type="text" class="form-control" style="resize:none" name="text_3" wire:model.lazy="text3" autocomplete="off" rows="3">{{$text3}}</textarea>
                      </div>
                    </div>
                  </div>
                  

                  <div class="row mb-4">
                    <div class="col-6">
                      <div class="input-group input-group-outline my-4">
                        @if ($topBanner)
                          <img src="{{ $topBanner->temporaryUrl() }}" width="150px" height="50px">
                        @elseif(!is_null($aboutUs))
                            <img src="{{ env('APP_URL').'storage/'.$aboutUs->top_banner }}" width="150px" height="50px">
                        @endif
                      </div>      
                      <div>
                        <label class="form-label">Top Banner</label>
                        <input type="file" class="form-control" name="topBanner" wire:model.lazy="topBanner">
                      </div> 
                    </div>

                    <div class="col-6">
                      <div class="form-check form-switch d-flex align-items-center ps-6 pt-4 mt-4">
                        <br>
                        <input class="form-check-input" type="checkbox" id="status" name="status" @if($showLowerBanner) checked @endif wire:model="showLowerBanner">
                        <label class="form-check-label mt-2 ms-2" for="status">Show Lower Banner</label>
                      </div>
                    </div>

                  </div>

                  <div class="row mb-6">
                    <div class="col-6">
                      <label class="form-label">Author</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="author" wire:model.lazy="author" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Designation</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="designation" wire:model.lazy="designation" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row mb-6">
                    <div class="col-6">
                      <label class="form-label">Quote</label>
                      <div class="input-group input-group-outline">
                        <textarea type="text" class="form-control" style="resize:none" name="quote" wire:model.lazy="quote" autocomplete="off" rows="3">{{$quote}}</textarea>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="input-group input-group-outline my-4">
                        
                        @if ($lowerBanner)
                          <img src="{{ $lowerBanner->temporaryUrl() }}" width="150px" height="50px">
                          <button type="button" wire:click="removeLowerBanner" style="position: relative; top: -17px; right: 20px; background: none; border: none; outline: none; cursor: pointer; font-weight: bold;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                              <path d="M10.354 4.354a.5.5 0 1 1 .708.708L8.707 8l2.354 2.354a.5.5 0 0 1-.708.708L8 8.707l-2.354 2.354a.5.5 0 1 1-.708-.708L7.293 8 4.939 5.646a.5.5 0 0 1 .708-.708L8 7.293l2.354-2.354a.5.5 0 0 1 .708 0z"/>
                            </svg>
                          </button>
                        @elseif(!is_null($aboutUs) && !is_null($aboutUs->lower_banner))
                            <img src="{{ env('APP_URL').'storage/'.$aboutUs->lower_banner }}" width="150px" height="50px">
                            <button type="button" wire:click="removeLowerBannerFromDB" style="position: relative; top: -17px; right: 20px; background: none; border: none; outline: none; cursor: pointer; font-weight: bold;">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M10.354 4.354a.5.5 0 1 1 .708.708L8.707 8l2.354 2.354a.5.5 0 0 1-.708.708L8 8.707l-2.354 2.354a.5.5 0 1 1-.708-.708L7.293 8 4.939 5.646a.5.5 0 0 1 .708-.708L8 7.293l2.354-2.354a.5.5 0 0 1 .708 0z"/>
                              </svg>
                            </button>
                        @endif
                       
                      </div>      
                      <div>
                        <label class="form-label">Lower Banner</label>
                        <input type="file" class="form-control" name="topBanner" wire:model.lazy="lowerBanner">
                      </div> 
                    </div>

                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($aboutUs)) Update @else Add @endif About Us</button>
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

