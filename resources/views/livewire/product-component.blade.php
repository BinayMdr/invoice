<div class="container-fluid pb-4">
    <div class="row">
      <div class="col-12">
        <div class="input-group d-flex  justify-content-end">
          <a type="button" class="btn btn-info mx-2" href="{{route('create.product')}}">
            <i class="material-icons opacity-10">add</i>
          </a>
          <div class="form-outline">
            <input type="search" id="form1" class="form-control px-2" style="border: 1px solid #d2d6da" wire:model="search"/>
          </div>
          <button type="button" class="btn btn-primary">
            <i class="material-icons opacity-10">search</i>
          </button>
        </div>
        <div class="card index">
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created At</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td>
                      <p class="text-xs font-weight-bold mb-0 px-3">{{$product->name}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0 px-3">{{'Rs. '. $product->price}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0 px-3">{{$product->is_enabled ? "Active" : "Inactive"}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{$product->created_at->format('Y-m-d')}}</p>
                    </td>
                    <td class="align-middle">
                      <a href="{{route('edit.product',['product' => $product])}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit banner">
                        Edit
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4">
      Page Limit:
      <select class="form-select px-2" style="border: 1px solid #d2d6da;width:60px" aria-label="Default select example" wire:click="changeEvent($event.target.value)">
        <option value="10" @if($limit == "10") selected @endif>10</option>
        <option value="25" @if($limit == "25") selected @endif>25</option>
        <option value="50" @if($limit == "50") selected @endif>50</option>
        <option value="100" @if($limit == "100") selected @endif>100</option>
      </select>
    </div>
    {{ $products->links('vendor.livewire.simple-bootstrap') }}
  </div>

@section('js')

@endsection