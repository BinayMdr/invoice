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
                        <th style="width:25%">Name</th>
                        <th style="width:25%">Email</th>
                        <th style="width:30%">Message Sent At</th>
                        <th style="width:20%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($messages as $message)
                      <tr>
                        <td>{{$message->name}}</td>
                        <td>{{$message->email}}</td>
                        <td>{{$message->created_at}}</td>
                        <td>
                            <a href="{{route('view.message',['message' => $message])}}" class="text-dark font-weight-bold text-xs">
                                <i class="material-icons opacity-10">visibility</i>
                            </a>
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
              @if($total > 0)
              <div class="col-4"> 
                Showing {{$start}}-{{$end}} of {{$total}} <br>
              </div>
              @endif
              <div class="col-4">
                {{ $messages->links('vendor.livewire.simple-bootstrap') }}
              </div>
            </div>
            
            
    
       
          </div>
        </div>
    </div>
    </div>
    
    @section('js')
    
    @endsection