<div>
  <style>
    .table th, .table td {
      padding: 12px !important;
      text-align: left !important;
      border-bottom: 1px solid #dee2e6 !important;
    }
    
    .table thead th {
      background-color: #f8f9fa !important;
      font-weight: bold !important;
      text-transform: uppercase;
      font-size: 12px;
      color: #6c757d !important;
    }
  
    .table tbody tr:nth-child(even) {
      background-color: #f9f9f9 !important;
    }
  
    .table tbody tr:hover {
      background-color: #e9ecef !important;
      transition: background-color 0.3s ease-in-out;
    }
  
    .table-responsive {
      border-radius: 8px !important;
      overflow: hidden !important;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
  
  <div class="container-fluid pb-4">
      <div class="row">
        <div class="col-12">
          <div class="input-group d-flex justify-content-end mb-4">
            @if(\Auth::user()->hasRole('add-pop-ups'))
              <a class="btn btn-info mx-2" href="{{route('create.pop-up')}}">
                <i class="material-icons opacity-10">add</i>
              </a>
            @endif
            <div class="form-outline">
              <input type="search" id="form1" class="form-control px-2" style="border: 1px solid #d2d6da" wire:model="search"/>
            </div>
            <button type="button" class="btn btn-primary">
              <i class="material-icons opacity-10">search</i>
            </button>
          </div>
          
          <div class="card">
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th style="width:20%">Name</th>
                      <th style="width:25%">Link</th>
                      <th style="width:20%">Status</th>
                      <th style="width:25%">Created At</th>
                      <th style="width:20%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($popUps as $popup)
                    <tr>
                      <td>{{$popup->name}}</td>
                      <td>{{$popup->link}}</td>
                      <td><span class="badge" style="background: {{ $popup->is_enabled ? 'green' : 'red' }};">
                        {{$popup->is_enabled ? "Active" : "Inactive"}}
                      </span></td>
                      <td>{{$popup->created_at}}</td>
                      <td>
                        @if(\Auth::user()->hasRole('edit-pop-ups'))
                          <a href="{{route('edit.pop-up',['popUp' => $popup])}}" class="text-dark font-weight-bold text-xs" style="margin-right:0.5rem">
                              <i class="material-icons opacity-10">edit</i>
                          </a>
                        @endif
                        @if(\Auth::user()->hasRole('delete-pop-ups'))
                          <a href="{{route('delete.pop-up',['popUp' => $popup])}}" class="text-dark font-weight-bold text-xs">
                              <i class="material-icons opacity-10">delete</i>
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
  
          <div class="row mt-4 w-full">
            <div class="col-4">
              <span>Page Limit:</span>
              <select class="form-select d-inline-block px-2 ms-2 py-1" 
                      style="border: 1px solid #d2d6da; width: 50px" 
                      aria-label="Default select example" 
                      wire:click="changeEvent($event.target.value)">
                <option value="10" @if($limit == "10") selected @endif>10</option>
                <option value="25" @if($limit == "25") selected @endif>25</option>
                <option value="50" @if($limit == "50") selected @endif>50</option>
                <option value="100" @if($limit == "100") selected @endif>100</option>
              </select>
            </div>
            <div class="col-4"> 
              @if($total > 0)
                Showing {{$start}}-{{$end}} of {{$total}} 
              @endif<br>
            </div>
            <div class="col-4">
              {{ $popUps->links('vendor.livewire.simple-bootstrap') }}
            </div>
          </div>
          
          
  
     
        </div>
      </div>
  </div>
  </div>
  
  @section('js')
  
  @endsection