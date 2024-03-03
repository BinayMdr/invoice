<div class="container-fluid px-2 px-md-4">
    <div class="card card-body mx-3">
      <div class="row">
        <div class="row">
          <div class="col-12">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3" style="display: flex; align-items: center; justify-content: space-between;">
                <h6 class="mb-0">Update Filter Tag</h6>
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
                @if($error)
                <div class="alert alert-danger alert-dismissible text-white" role="alert">
                  <span class="text-sm">{{ $error}}</span>
                  <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
                <form class="text-start" wire:submit.prevent="save" >  
                
                <div id="sortable-list">
                  @foreach($tags as $count => $tag)
                  <div data-id="{{ $tag['id'] }}" data-tag-id="{{$tag['tagId']}}" wire:key="tag-{{ $tag['id'] }}">
                    <div class="row mb-4">
                      <div class="col-6">
                        <label class="form-label">Name</label>
                        <div class="input-group input-group-outline">
                          <input type="text"  class="form-control" name="name-{{$count}}"  autocomplete="off" value="{{$tag['name']}}" readonly>
                        </div>
                      </div>
                      <div class="col-6 pt-4">
                        <a type="button" class="btn btn-info mx-2" href="{{route('filter-product',['tag' => $tag['tagId']])}}">
                          Filter Product
                        </a>
                      </div>
                    </div> 
                  </div>
                  @endforeach
                </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Update Filter Tag</button>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
  <script>
    document.addEventListener('livewire:load', function () {
        new Sortable(document.getElementById('sortable-list'), {
            animation: 150,
            onEnd: function (evt) {
                let item = evt.item;
                let rows = Array.from(item.parentElement.children).map((el, index) => {
                    let id = el.dataset.id;
                    let tagId = el.dataset.tagId;
                    let name = el.querySelector('input[name^="name-"]').value;
                    if(id == "") id = null;
                    return {
                        id: id,
                        name: name,
                        tagId:tagId
                    };
                });
                Livewire.emit('filterTagUpdated', rows);
            }
        });
    });
</script>
  @endsection

