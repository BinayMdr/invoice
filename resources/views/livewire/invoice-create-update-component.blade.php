<div>
    @if($existingCustomer)
        <div class="input-group input-group-outline my-3 is-filled">
            <label class="form-label">Customer</label>
            <input type="text" class="form-control" name="customerId" @if($existingCustomer) required @endif autocomplete="off" wire:model.debounce.500ms="customerDetail" @if($type == "Update") readonly @endif>
        </div>
        @if($customerDetailError)
            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                <span class="text-sm">User not found</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @endif
    @if(!$existingCustomer)
        <div class="input-group input-group-outline my-3 is-filled">
            <label class="form-label">Customer Name</label>
            <input type="text" class="form-control" name="name" @if(!$existingCustomer) required @endif  autocomplete="off" wire:model.debounce.500ms="customerName">
        </div>
        <div class="input-group input-group-outline my-3 is-filled">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" @if(!$existingCustomer) required @endif  autocomplete="off" wire:model.debounce.500ms="phoneNumber">
        </div>   
        @if($phoneNumberError)
            <div class="alert alert-danger alert-dismissible text-white" role="alert">
            <span class="text-sm">Phone number already exists</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
    @endif

    @if($type != "Update")         
      <button type="button" class="btn bg-gradient-success" wire:click="updateCustomerStatus">
          @if($existingCustomer)Add new customer @else Existing customer @endif</button>
    @endif

    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-30">Product Name</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
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
                    <button type="button"  wire:click="updateQuantity({{$count}},'substract')">-</button>
                    {{$product['quantity']}}
                    <button type="button"   wire:click="updateQuantity({{$count}},'add')">+</button>
                  </p>
              </td>
              <td>
                <p class="text-xs font-weight-bold mb-0">{{$product['price']}}</p>
              </td>
              <td class="align-middle">
                <p class="text-xs font-weight-bold mb-0">{{$product['total']}}</p>
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
                          <option value="{{$p->id}}">{{$p->name}}</option>
                        @endforeach
                      </select>
                    </div>
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">0</p>
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">Rs. 0</p>
                </td>
                <td class="align-middle">
                    <p class="text-xs font-weight-bold mb-0">Rs. 0</p>
                </td>
                <td class="align-middle">
                    {{-- <p class="text-xs font-weight-bold mb-0">Rs. 0</p> --}}
                </td>
            </tr>
            @endif
            <tr>
              <td>
              </td>
              <td>
              </td>
              <td>
              </td>
              <td class="align-middle">
                SubTotal: 
              </td>
              <td class="align-middle">
                  Rs. {{$subTotal}}
              </td>
            </tr>
            <tr>
              <td>
              </td>
              <td>
              </td>
              <td>
              </td>
              <td class="align-middle">
                Discount(%): 
              </td>
              <td class="align-middle w-20">
                <div class="input-group input-group-outline my-3 is-filled">
                  <input type="number" class="form-control" name="discount" autocomplete="off" wire:model.debounce.500ms="discountPercent" @if($type == "Update") readonly @endif >
                </div>
                </td>
            </tr>
            <tr>
              <td>
              </td>
              <td>
              </td>
              <td>
              </td>
              <td class="align-middle">
                Total: 
              </td>
              <td class="align-middle w-20">
                Rs. {{$total}}
                </td>
            </tr>
          </tbody>
        </table>

        <div>
          <div class="input-group input-group-outline my-3 is-filled">
            <label class="form-label">Payment Method</label>
            <select class="form-control" id="paymentMethod">
              <option value="" @if($paymentMethod == "" || is_null($paymentMethod) )selected @endif >Select payment method</option>
              @foreach(\App\Models\PaymentMethod::where('is_enabled','1')->get() as $pm)
                <option value="{{$pm->name}}" @if( $type == "Update" && $pm->name == $paymentMethod) 
                    selected @endif>{{$pm->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
       
        <div class="input-group input-group-outline my-3 is-filled">
          <label class="form-label">Received Amount</label>
          <input type="number" class="form-control" name="receivedAmount" autocomplete="off" wire:model.debounce.500ms="receivedAmount">
        </div>

        <p class="text-xs font-weight-bold mb-0">Changed Amount: Rs. {{$changedAmount}}</p>
      </div>

      @if($type == "Update")
      <div>
        <div class="input-group input-group-outline my-3 is-filled">
          <label class="form-label">Invoice Status</label>
            <select class="form-control" id="invoiceStatus">
                <option value="Pending" @if( $type == "Update" && $invoiceStatus == "Pending") 
                    selected @endif>Pending</option>
                <option value="Paid" @if( $type == "Update" && $invoiceStatus == "Paid") 
                    selected @endif>Paid</option>
            </select>
          </div>
        </div>
      @endif
      <div class="text-center">
        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2" @if($type=="Add") wire:click="save" @else wire:click="update" @endif @if($disableButton) disabled @endif>{{$type}} Invoice</button>
      </div>
      
      @if($type == "Update")
      <div class="text-center">
        <a type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" href="{{route('download.invoice',['invoiceId' => $invoiceId])}}">Download Receipt</a>
      </div>
    @endif
    <!-- Modal -->
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

        $('select#invoiceStatus').on('change', function (e) {
          Livewire.emit('updateInvoiceStatus',$('select#invoiceStatus :selected').val())
        });
    </script>
@endsection