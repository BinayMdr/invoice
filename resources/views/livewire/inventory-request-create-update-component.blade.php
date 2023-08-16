<div>
  
    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-30">Product Name</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($productLists as $count => $product)
            {{-- {{dd($product)}} --}}
            <tr>
              <td>
                <p class="text-xs font-weight-bold mb-0 px-3">{{$product['name']}}</p>
              </td>
              <td>
                  <p class="text-xs font-weight-bold mb-0">
                    <button type="button"  wire:click="updateQuantity({{$count}},'substract',{{$product['max_quantity']}})">-</button>
                    {{$product['quantity']}}
                    <button type="button"   wire:click="updateQuantity({{$count}},'add',{{$product['max_quantity']}})">+</button>
                  </p>
              </td>
              <td class="align-middle">
                <a class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" style="cursor: pointer;" data-original-title="Edit user" wire:click="deleteProduct({{$count}})">
                  Delete
                </a>
              </td>
            </tr>
            @endforeach
            @if($type != "Update")   
            <tr>
                <td>
                    <div class="input-group input-group-outline my-3 is-filled">
                      <select class="form-control" id="products">
                        <option value="">Select product</option>
                        @foreach($this->productNameList as $p)
                          <option value="{{$p->id}}" @if($p->total == 0) disabled @endif>{{$p->name}}</option>
                        @endforeach
                      </select>
                    </div>
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">0</p>
                </td>
                <td class="align-middle">
                    {{-- <p class="text-xs font-weight-bold mb-0">Rs. 0</p> --}}
                </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>

      @php
        $userType = \Auth::user()->type;
      @endphp
      @if($type == "Update")
      <div>
        <div class="input-group input-group-outline my-3 is-filled">
          <label class="form-label">Inventory Request Status</label>
            <select class="form-control" id="inventoryRequestStatus" @if($userType != "admin") disabled="true" @endif>
                <option value="Pending" @if( $type == "Update" && $inventoryRequestStatus == "Pending") 
                    selected @endif>Pending</option>
                <option value="Rejected" @if( $type == "Update" && $inventoryRequestStatus == "Rejected") 
                    selected @endif>Rejected</option>
                <option value="Completed" @if( $type == "Update" && $inventoryRequestStatus == "Completed") 
                    selected @endif>Completed</option>
            </select>
          </div>
        </div>
      @endif
      @if($userType == "admin")
        <div class="text-center">
          <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2" @if($type=="Add") wire:click="save" @else wire:click="update" @endif>{{$type}} Inventory Request</button>
        </div>
      @endif
  
</div>

@section('js')
    <script>    
        $("select#products").select2({
            tags:true
        });

        $('select#products').on('change', function (e) {
          Livewire.emit('productAdded',$('select#products :selected').val())
        });

        window.addEventListener('contentChanged', (e) => {
            $("select#products").select2({
              tags:true
            });
        });

        $('select#paymentMethod').on('change', function (e) {
          Livewire.emit('updatePaymentMethod',$('select#paymentMethod :selected').val())
        });

        $('select#inventoryRequestStatus').on('change', function (e) {
          Livewire.emit('updateInventoryRequestStatus',$('select#inventoryRequestStatus :selected').val())
        });
    </script>
@endsection