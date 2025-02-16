<div class="container-fluid px-2 px-md-4">
    <div class="card card-body mx-3">
      <div class="row">
        <div class="row">
          <div class="col-12">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">@if($certification) Update @else Add @endif certification </h6>
              </div>
              <div class="card-body">
            
                @if(\Session::has('success'))
                  <div class="alert alert-success alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{\Session::get('success')}}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                <form class="text-start" 
                      wire:submit.prevent="update"  
                  >  
                  <input type="file" class="form-control" name="image" wire:model="photos" multiple accept="image/*">

                  
                  <div class="d-flex mt-3" style="gap: 10px; overflow-x: auto;">
                    @foreach ($photos as $index => $photo)
                        <div style="position: relative;">
                            <img src="{{ $photo->temporaryUrl() }}" width="100" height="100" class="rounded">
                            <button type="button" class="btn btn-danger btn-sm"
                                    style="position: absolute; top: -5px; right: -5px; background:transparent;box-shadow:none"
                                    wire:click="removePhoto({{ $index }})">
                                &times;
                            </button>
                        </div>
                    @endforeach
                </div>
            
                <div class="d-flex mt-3" style="gap: 10px; overflow-x: auto;">
                    @foreach ($storedPhotos as $index => $storedPhoto)
                        <div style="position: relative;">
                            <img src="{{ asset('storage/' . $storedPhoto->image) }}" width="100" height="100" class="rounded">
                            @if(\Auth::user()->hasRole('delete-certifications'))
                            <button type="button" class="btn btn-danger btn-sm"
                                    style="position: absolute; top: -5px; right: -5px;background:transparent;box-shadow:none"
                                     wire:click.debounce.500ms="removeStoredPhoto({{ $storedPhoto->id }})">
                                &times;
                            </button>
                            @endif

                        </div>
                    @endforeach
                </div>
                @if(\Auth::user()->hasRole('add-certifications') || \Auth::user()->hasRole('edit-certifications') )
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2"> @if($certification) Update @else Add @endif Certification</button>
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

  @section('js')
    <script>
       Livewire.on('refreshComponent', () => {
        window.location.reload(); // Hard refresh the page (last resort)
    });
    </script>
  @endsection
