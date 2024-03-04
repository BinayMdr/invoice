<div class="container-fluid px-2 px-md-4">
  <div class="card card-body mx-3">
    <div class="row">
      <div class="row">
        <div class="col-12">
          <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">@if(!is_null($product)) Update product @else Add product @endif </h6>
            </div>
            <div class="card-body">
              @error('name')
                @include('partials.error_alert', ['message' => $message])
              @enderror
              @error('slug')
                @include('partials.error_alert', ['message' => $message])
              @enderror
              @error('image')
                @include('partials.error_alert', ['message' => $message])
              @enderror
              @error('images')
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
                @if(!is_null($product))
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
                    <label class="form-label">Slug</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="slug" wire:model.lazy="slug" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-6">
                    <label class="form-label">Category</label>
                      <div class="input-group input-group-outline" aria-autocomplete="off" >
                        <select class="form-select form-control" aria-label="Default select example" name="group_id" wire:model="categoryId">

                          <option value="" selected>Select One</option>
                          @foreach(\App\Models\Category::orderBy('order')->get() as $category)
                            <option value="{{$category->id}}" @if( $category->id == $categoryId ) selected @endif>{{$category->name}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="col-6">
                    <label class="form-label">Color</label>
                      <div class="input-group input-group-outline" aria-autocomplete="off" >
                        <select class="form-select form-control" aria-label="Default select example" name="group_id" wire:model="colorId">
                          <option value="" selected>Select One</option>
                          @foreach(\App\Models\Color::orderBy('order')->get() as $color)
                            <option value="{{$color->id}}" @if( $color->id == $colorId ) selected @endif>{{$color->name}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="row mb-6">
                  <div class="col-6">
                    <label class="form-label">Brand</label>
                      <div class="input-group input-group-outline" aria-autocomplete="off" >
                        <select class="form-select form-control" aria-label="Default select example" name="group_id" wire:model="brandId">

                          <option value="" selected>Select One</option>
                          @foreach(\App\Models\Brand::orderBy('order')->get() as $brand)
                            <option value="{{$brand->id}}" @if( $brand->id == $brandId ) selected @endif>{{$brand->name}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="col-6 mb-4">
                    <label class="form-label">Tags</label>
                      <div class="input-group input-group-outline" aria-autocomplete="off" >
                        <select class="form-select form-control" aria-label="Default select example" name="group_id" wire:model="tags" multiple aria-label="multiple select example">
                          @foreach(\App\Models\Tag::orderBy('order')->get() as $tag)
                            @if(is_null($product))
                              <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @elseif( $tempTag != $tags)
                             <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @else
                              <option value="{{$tag->id}}" @if( in_array($tag->id, $tags) ) selected @endif>{{$tag->name}}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-4">
                    <label class="form-label">Price</label>
                    <div class="input-group input-group-outline">
                      <input type="number" class="form-control" name="price" wire:model.lazy="price" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-4">
                    <label class="form-label">Discounted Price</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="discountedPrice" wire:model.lazy="discountedPrice" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-4">
                    <label class="form-label">Sale Price</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="salePrice" wire:model.lazy="salePrice" autocomplete="off">
                    </div>
                  </div>
                </div>

                <div class="row mb-6">
                  <div class="col-4">
                    <div class="form-check form-switch d-flex align-items-center ps-6 mt-6">
                      <br>
                      <input class="form-check-input" type="checkbox" id="new" name="new" @if($isNew) checked @endif wire:model="isNew">
                      <label class="form-check-label mt-2 ms-2" for="new">New</label>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-check form-switch d-flex align-items-center ps-6 mt-6">
                      <br>
                      <input class="form-check-input" type="checkbox" id="outofstock" name="outofstock" @if($isOutOfStock) checked @endif wire:model="isOutOfStock">
                      <label class="form-check-label mt-2 ms-2" for="outofstock">Out of stock</label>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-check form-switch d-flex align-items-center ps-6 mt-6">
                      <br>
                      <input class="form-check-input" type="checkbox" id="status" name="status" @if($isEnabled) checked @endif wire:model="isEnabled">
                      <label class="form-check-label mt-2 ms-2" for="status">Status</label>
                    </div>
                  </div>
                </div>

                <div class="row mb-6">
                  <div class="col-6">
                    <label class="form-label">Short Description</label>
                    <div class="input-group input-group-outline">
                      <textarea type="text" class="form-control" style="resize:none" name="shortDescription" wire:model.lazy="shortDescription" autocomplete="off" rows="3">{{$shortDescription}}</textarea>
                    </div>
                  </div>
                  <div class="col-6">
                    <label class="form-label">Additional Information</label>
                    <div class="input-group input-group-outline">
                      <textarea type="text" class="form-control" style="resize:none" name="additionalInformation" wire:model.lazy="additionalInformation" autocomplete="off" rows="3">{{$additionalInformation}}</textarea>
                    </div>
                  </div>
                </div>

                <div class="row mb-12">
                    <label class="form-label">Description</label>
                    <div class="input-group input-group-outline">
                      <textarea type="text" class="form-control" style="resize:none" name="description" id="description" wire:model.lazy="description" autocomplete="off" row="5">{{$description}}</textarea>
                    </div>
                </div>

                <div class="row pt-6">
                  <div class="col-12">
                    <div class="my-4" style="width: 50%; height: 150px; overflow: hidden;">
                      @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" style="width: 30%; height: 100%;">
                      @elseif(!is_null($product))
                          <img src="{{ env('APP_URL').'storage/'.$product->display_image }}" style="width: 30%; height: 100%;">
                      @endif
                    </div>      
                    <div>
                      <label class="form-label">Display Image</label>
                      <input type="file" class="form-control" name="image" wire:model.lazy="image">
                    </div> 
                  </div>

                </div>   

                <div class="row pt-2">
                  <div class="col-12">
                    <div class="my-4" style="width: 100%; height: 100px; overflow-x: auto; white-space: nowrap;">
                      @if ($images)
                        @foreach($images as $productImage)
                          <img src="{{ $productImage->temporaryUrl() }}" style="width: 20%; height: 100%;">
                        @endforeach
                      @elseif(!is_null($product))
                          @foreach(explode(",",$product->images) as $img)
                            <img src="{{ env('APP_URL').'storage/'.$img }}" style="width: 20%; height: 100%;">
                          @endforeach
                      @endif
                    </div>      
                    <div>
                      <label class="form-label">Images</label>
                      <input type="file" class="form-control" name="images" wire:model.lazy="images" multiple>
                    </div> 
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">@if(!is_null($product)) Update @else Add @endif Product</button>
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

@section('js')
<script src="https://cdn.tiny.cloud/1/7anhnny90yb3ecdfq3bwuqtzrja0kuca90dnnjybjii4cde6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>

  var app = {
    init(){
      tinymce.init({
                selector: 'textarea#description',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                        var content = editor.getContent();
                        @this.set('description', content);
                    });
                },
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                mergetags_list: [
                    { value: 'First.Name', title: 'First Name' },
                    { value: 'Email', title: 'Email' },
                ],
                ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
            });
    }
  }
  $(function(){
      app.init();
    });

    window.livewire.on('render-list',id=> {
        app.init();
	  });
</script>
@endsection


