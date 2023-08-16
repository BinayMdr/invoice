<div class="container-fluid pb-4">
    <div class="row">
      <div class="col-12">
        @php
        $user = \Auth::user();
        $showButton = true;
        $branch = \App\Models\Branch::where('is_enabled','1')->where('main_branch','1')->first();
        if($user->type == "admin") $showButton = false;
        else if($user->branch == $branch->id) $showButton = false;
      @endphp


        <div class="input-group d-flex  justify-content-end">
          @if($user->branch != $branch->id)
            <a type="button" class="btn btn-info mx-2" href="{{route('inventory-request')}}">
              View Request
            </a>
          @endif

          @if(!$showButton)
            <a type="button" class="btn btn-info mx-2" href="{{route('create.inventory')}}">
              <i class="material-icons opacity-10">add</i>
            </a>
          @endif
         
          @if($showButton)
            <a type="button" class="btn btn-info mx-2" href="{{route('create.inventory-request')}}">
                Make Request
            </a>
          @endif

          <div class="form-outline">
            <input type="search" id="form1" class="form-control px-2" style="border: 1px solid #d2d6da" wire:model="search"/>
          </div>
          <button type="button" class="btn btn-primary">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <div class="card">
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Count</th>
                    @if(!$showButton)
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($inventories as $inventory)
                  <tr>
                    <td>
                      <p class="text-xs font-weight-bold mb-0 px-3">{{$inventory->name}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0 px-3">{{$inventory->total}}</p>
                    </td>
                    @if(!$showButton)
                      <td class="align-middle">
                        <a href="{{route('edit.inventory',['inventory' => $inventory])}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    @endif
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
        <option value="20" @if($limit == "50") selected @endif>50</option>
        <option value="100" @if($limit == "100") selected @endif>100</option>
      </select>
    </div>
    {{ $inventories->links('vendor.livewire.simple-bootstrap') }}
  </div>

@section('js')

@endsection