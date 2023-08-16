<div class="container-fluid pb-4">
    <div class="row">
      <div class="col-12">
        <div class="input-group input-group-outline my-3 is-filled row">
          <div class="col-4">
            <label>Inventory Request Status</label>
            <select class="form-control" id="inventoryRequestStatus" wire:click="updateInventoryRequestStatus($event.target.value)">
                <option value="" @if($inventoryRequestStatus == "") selected @endif>Select Inventory Request Status</option>
                <option value="Pending" @if($inventoryRequestStatus == "Pending") selected @endif>Pending</option>
                <option value="Completed" @if($inventoryRequestStatus == "Completed") selected @endif>Completed</option>
                <option value="Rejected" @if($inventoryRequestStatus == "Rejected") selected @endif>Rejected</option>
            </select>
          </div>
          <div class="col-3">
            <label>Start Date</label>
            <input type="date" id="form1" class="form-control px-2" style="border: 1px solid #d2d6da" wire:model="startDate"/>
          </div>  
          <div class="col-3">
            <label>End Date</label>
            <input type="date" id="form1" class="form-control px-2" style="border: 1px solid #d2d6da" wire:model="endDate"/>
          </div>
          <div class="col-2 pt-4 mt-2">
           <button type="button" class="btn btn-primary" wire:click="clear">Clear</button>
          </div>
          </div>
        <div class="input-group d-flex  justify-content-end">
          <a type="button" class="btn btn-info mx-2" href="{{route('create.inventory-request')}}">
            <i class="material-icons opacity-10">add</i>
          </a>
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Branch</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created By</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created At</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($inventoryRequests as $inventoryRequest)
                  <tr>
                    <td>
                      <p class="text-xs font-weight-bold mb-0 px-3">{{\App\Models\Branch::find($inventoryRequest->branch_id)->name}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0 px-3">{{\App\Models\User::find($inventoryRequest->user_id)->name}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($inventoryRequest->created_at)->tz('Asia/Kathmandu') }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{$inventoryRequest->status}}</p>
                    </td>
                    <td class="align-middle">
                      <a href="{{route('edit.inventory-request',['inventoryRequest' => $inventoryRequest])}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a>
                      {{-- @if(Auth::user()->type == "admin")
                        <a href="{{route('delete.invoice',['invoice' => $invoice])}}" class="text-secondary font-weight-bold text-xs ps-2" data-toggle="tooltip" data-original-title="Edit user">
                          Delete
                        </a>
                      @endif --}}
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
        <option value="20" @if($limit == "50") selected @endif>50</option>
        <option value="100" @if($limit == "100") selected @endif>100</option>
      </select>
    </div>
    {{ $inventoryRequests->links('vendor.livewire.simple-bootstrap') }}
  </div>

@section('js')

@endsection

@section('js')
    <script>
        $('select#inventoryRequestStatus').on('change', function (e) {
          Livewire.emit('updateInventoryRequestStatus',$('select#inventoryRequestStatus :selected').val())
        });
    </script>
@endsection