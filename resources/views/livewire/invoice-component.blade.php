<div class="container-fluid pb-4">
    <div class="row">
      <div class="col-12">
        <div class="input-group input-group-outline my-3 is-filled row">
          <div class="col-4">
            <label>Invoice Status</label>
            <select class="form-control" id="invoiceStatus" wire:click="updateInvoiceStatus($event.target.value)">
                <option value="" @if($invoiceStatus == "") selected @endif>Select Invoice Status</option>
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
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
          <a type="button" class="btn btn-info mx-2" href="{{route('create.invoice')}}">
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Invoice No.</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created At</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Prepared By</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($invoices as $invoice)
                  <tr>
                    <td>
                      <p class="text-xs font-weight-bold mb-0 px-3">{{$invoice->invoice_number}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{\App\Models\Customer::find($invoice->customer_id)->name}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($invoice->created_at)->tz('Asia/Kathmandu') }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{$invoice->prepared_by_id}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{$invoice->status}}</p>
                    </td>
                    <td class="align-middle">
                      <a href="{{route('edit.invoice',['invoice' => $invoice])}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a>
                      @if(Auth::user()->type == "admin")
                        <a href="{{route('delete.invoice',['invoice' => $invoice])}}" class="text-secondary font-weight-bold text-xs ps-2" data-toggle="tooltip" data-original-title="Edit user">
                          Delete
                        </a>
                      @endif
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
    {{ $invoices->links('vendor.livewire.simple-bootstrap') }}
  </div>

@section('js')

@endsection

@section('js')
    <script>
        $('select#invoiceStatus').on('change', function (e) {
          Livewire.emit('updateInvoiceStatus',$('select#invoiceStatus :selected').val())
        });
    </script>
@endsection