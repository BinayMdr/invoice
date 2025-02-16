<div class="container-fluid px-2 px-md-4">
  <style>
    div.tox-dialog-wrap{
      width: 70%!important;
      margin-left:25%!important;
      height: 80%!important;
      margin-top:4%!important;
    }
  </style>
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
                  <div class="col-4">
                    <label class="form-label">Name <span class="text-danger">*</span> </label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="name" wire:model.lazy="name" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-4">
                    <label class="form-label">Slug <span class="text-danger">*</span> </label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="slug" wire:model.lazy="slug" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="col-4">
                    <label class="form-label">Order</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="order" wire:model.lazy="order" autocomplete="off">
                    </div>
                  </div>
                </div>

               

                <div class="row mb-4">
                  <div class="col-4">
                    <label class="form-label">Price</label>
                    <div class="input-group input-group-outline">
                      <input type="number" class="form-control" name="price" min="1" wire:model.lazy="price" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-4">
                    <label class="form-label">Series</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="series" wire:model.lazy="series" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-4">
                    <label class="form-label">Reference</label>
                    <div class="input-group input-group-outline">
                      <input type="text" class="form-control" name="reference" wire:model.lazy="reference" autocomplete="off">
                    </div>
                  </div>
                </div>

                <div class="row mb-6">
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
                  <div class="col-4">
                    <div class="form-check form-switch d-flex align-items-center ps-6 mt-6">
                      <br>
                      <input class="form-check-input" type="checkbox" id="showInHomePage" name="showInHomePage" @if($showInHomePage) checked @endif wire:model="showInHomePage">
                      <label class="form-check-label mt-2 ms-2" for="showInHomePage">Show in home page</label>
                    </div>
                  </div>
                </div>

              

                <div class="row mb-12">
                    <label class="form-label">Description</label>
                    <div class="input-group input-group-outline" wire:ignore>
                      <textarea type="text" class="form-control"  name="description" id="description" wire:model.lazy="description" autocomplete="off" >{{$description}}</textarea>
                    </div>
                </div>


                <div class="row pt-6">
                  <div class="col-12">
                    <div class="my-4" style="width: 50%; height: 150px; overflow: hidden;">
                      @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" style="width: 30%; height: 100%;">
                      @elseif(!is_null($product))
                          <img src="{{ env('APP_URL').'storage/'.$product->image }}" style="width: 30%; height: 100%;">
                      @endif
                    </div>      
                    <div>
                      <input type="file" class="form-control" name="image" wire:model.lazy="image" accept="image/*">
                    </div> 
                    <label class="form-label">Image @if(!$product)<span class="text-danger">*</span> @endif</label>
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

document.addEventListener('livewire:load', function () {
    initTinyMCE();
});

document.addEventListener('livewire:update', function () {
    if (!tinymce.get('description')) {
        initTinyMCE();
    }
});

function initTinyMCE() {
    tinymce.init({
        selector: 'textarea#description',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
                var content = editor.getContent();
                Livewire.emit('updateDescription', content);
            });
        },
        // plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        // toolbar: 'undo redo | bold italic underline | link image media table | numlist bullist',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code fullscreen preview hr pagebreak insertdatetime nonbreaking help',
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | link image media table | numlist bullist | forecolor backcolor | fontselect fontsizeselect | code  preview hr',
    });
}

</script>
@endsection


