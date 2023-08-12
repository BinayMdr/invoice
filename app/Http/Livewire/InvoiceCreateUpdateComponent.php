<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceHasProduct;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvoiceCreateUpdateComponent extends Component
{
    public $existingCustomer = true;
    public $phoneNumber = "";
    public $phoneNumberError = false;
    public $customerDetail = "";
    public $customerName = "";
    public $customerDetailError = false;
    public $productLists = [];
    public $productName = "";
    public $productNameList = [];
    public $subTotal = 0;
    public $total = 0;
    public $discountPercent = 0;
    public $discountAmount = 0;
    public $receivedAmount = 0;
    public $changedAmount = 0;
    public $type ;
    public $disableButton = true;
    public $paymentMethod = null;
    public $invoiceId = null;
    public $invoiceStatus = null;
    protected $listeners = ['productAdded','updatePaymentMethod','updateInvoiceStatus'];

    public function mount($type,$invoice_id)
    {
        $this->type = $type;
        if($type == "Update")
        {
            $this->invoiceId = $invoice_id;
            $invoice = Invoice::find($invoice_id);
            $customer = Customer::find($invoice->customer_id);
            $this->customerDetail = $customer->name."(".$customer->phone_number.")";

            $this->discountPercent = $invoice->discount_percent;
            $this->discountAmount = $invoice->discount_amount;
            $this->receivedAmount = $invoice->received_amount;
            $this->paymentMethod = !is_null($invoice->payment_method_id) ?
                                        PaymentMethod::find($invoice->payment_method_id)->name 
                                        : null;
            $this->invoiceStatus = $invoice->status;

            foreach(InvoiceHasProduct::where('invoice_id',$invoice_id)->get() as $product)
            {
                $item_array = [
                    'id' => $product->product_id,
                    'name' => Product::find($product->product_id)->name,
                    'quantity' => $product->quantity,
                    "price" => $product->price,
                    "total" => $product->price
                ];
    
                array_push($this->productLists,$item_array);
            }
            
        }
        $this->productNameList = Product::orderby('name','ASC')->get();
    }
    public function render()
    {
        $this->updateCustomerTab();

        $this->updateAmount();

        $this->changedAmount = $this->receivedAmount - $this->total;

        return view('livewire.invoice-create-update-component');
    }

    public function updateCustomerStatus()
    {   
        $this->existingCustomer = !$this->existingCustomer;
        $this->updateCustomerTab();
    }

    public function productAdded($id)
    {
        $item = Product::find($id);
        
        if(!is_null($item))
        {
            $item_array = [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => "1",
                "price" => $item->price,
                "total" => $item->price
            ];

            array_push($this->productLists,$item_array);
            $this->updateProductList();
        }   
        $this->updateAmount();
    }

    public function updateQuantity($itemNumber,$type)
    {
        $previousQuantity = $this->productLists[$itemNumber]['quantity'];
        $newQuantity = $previousQuantity;
        
        if($type == "add") $newQuantity = $previousQuantity + 1;
        else if($previousQuantity > 1) $newQuantity = $previousQuantity - 1;
        
        $this->productLists[$itemNumber]['quantity'] = $newQuantity;
        $this->productLists[$itemNumber]['total'] = $newQuantity * $this->productLists[$itemNumber]['price'];
        $this->updateAmount();
    }

    public function updateAmount()
    {
        $this->subTotal = 0;
        $this->total = 0;
        if(count($this->productLists) > 0)
        {
            foreach($this->productLists as $product)
            {
                $this->subTotal += $product['total'];
            }

            if($this->discountPercent == 0) $this->total = $this->subTotal;
            else 
            {
                if(!is_numeric($this->discountPercent)) $this->discountPercent = 0;
                $this->total = $this->subTotal - ($this->discountPercent/100) * $this->subTotal;
            }
        }
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function deleteProduct($itemNumber)
    {
        $itemList = array();
        foreach($this->productLists as $count => $product)
        {
            if($count != $itemNumber)
            {
                $item_array = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                    "price" => $product['price'],
                    "total" => $product['total']
                ];
    
                array_push($itemList,$item_array);
            }
        }

        $this->productLists = $itemList;

        $this->updateProductList();
        $this->updateAmount();
    }

    public function updateProductList()
    {
        if(count($this->productLists) > 0)
        {
            $idList = array_column($this->productLists,'id');
            $this->productNameList = Product::whereNotIn('id',$idList)->orderby('name','ASC')->get();
        }
    }

    public function updateCustomerTab()
    {
        $this->disableButton = true;
        if($this->existingCustomer) $this->phoneNumberError = false;
        if(!$this->existingCustomer && $this->phoneNumber != "")
        {
            $this->customerDetailError = false;
            if( Customer::where('phone_number',$this->phoneNumber)->get()->count() > 0) 
            {
                $this->phoneNumberError = true;
                $this->disableButton = true;
            }
            else
            {
                if(count($this->productLists) > 0) $this->disableButton = false;
                else $this->disableButton = true;
            }
        }

        if($this->existingCustomer && $this->customerDetail != "")
        {
            $this->phoneNumberError = false;
            $customer = Customer::where('phone_number',$this->customerDetail)->first();
            if( !is_null($customer)) 
            {
                $this->customerDetail = $customer->name."(".$customer->phone_number.")";
                $this->customerDetailError = false;
                if(count($this->productLists) > 0) $this->disableButton = false;
                else $this->disableButton = true;
            }
            else 
            {
                if(str_contains($this->customerDetail,")") && str_contains($this->customerDetail,"("))
                {
                    $selectedCustomer = explode("(",$this->customerDetail);
                    $selectedCustomer = explode(")",$selectedCustomer[1]);
                    $customer = Customer::where('phone_number',$selectedCustomer)->first();

                    if( !is_null($customer)) 
                    {
                        $this->customerDetail = $customer->name."(".$customer->phone_number.")";
                        $this->customerDetailError = false;
                        if(count($this->productLists) > 0) $this->disableButton = false;
                        else $this->disableButton = true;
                    }
                    else $this->customerDetailError = true;
                }
            }
        }
    }

    public function save()
    {
        $customer = null;

        if($this->existingCustomer)
        {
            $selectedCustomer = explode("(",$this->customerDetail);
            $selectedCustomer = explode(")",$selectedCustomer[1]);
            $customer = Customer::where('phone_number',$selectedCustomer)->first();
        }
        else
        {
            $customer = Customer::create([
                            'name' => $this->customerName,
                            'phone_number' => $this->phoneNumber
                        ]);
        }

        $invoice = new Invoice();
        $invoice->invoice_number = $this->generate_order_code();
        $invoice->customer_id = $customer->id;
        $invoice->sub_total = $this->subTotal;
        $invoice->discount_percent = $this->discountPercent;
        $invoice->discount_amount = $this->discountAmount;
        $invoice->total = $this->total;
        $invoice->total = $this->total;
        $invoice->received_amount = $this->receivedAmount;
        $invoice->changed_amount = $this->changedAmount;
        $invoice->prepared_by_id = Auth::user()->name;
        $invoice->branch_id = Auth::user()->branch_id;
        $invoice->status = $this->changedAmount >= 0 ? "Paid" : "Pending";
        $invoice->payment_method_id = !is_null($this->paymentMethod) || $this->paymentMethod != "" ? 
                                PaymentMethod::where('name',$this->paymentMethod)->first()->id : null; 
        $invoice->save();

        foreach($this->productLists as $product)
        {
            $invoiceProduct = new InvoiceHasProduct();
            $invoiceProduct->invoice_id = $invoice->id;
            $invoiceProduct->product_id = $product['id'];
            $invoiceProduct->quantity = $product['quantity'];
            $invoiceProduct->price = $product['price'];
            $invoiceProduct->total = $product['total'];
            $invoiceProduct->save();
        }

        return redirect()->route('invoice')->with('success','Invoice Created');
    }

    private function generate_order_code()
    {
        $orders = Invoice::all();
        if($orders->isEmpty())
        {
            return 'MV0001';
        }
        else
        {
            $latest_order_code = Invoice::latest()->first()->invoice_number;
            $latest_order_code = str_replace("MV","",$latest_order_code);
            $new_code = (int)$latest_order_code + 1;
            for($i = strlen((string)$new_code) ; $i < 4 ; $i++)
            {  
                $new_code = '0'.$new_code;
            }
            $order_code = 'MV'.$new_code;
            return $order_code;
        }
    }

    public function updatePaymentMethod($name)
    {
        $this->paymentMethod = $name;
        $this->updateAmount();
    }

    public function updateInvoiceStatus($name)
    {
        $this->invoiceStatus = $name;
        $this->updateAmount();
    }

    public function update()
    {
        $invoice = Invoice::find($this->invoiceId);
        $invoice->update([
            'payment_method_id' => !is_null($this->paymentMethod) || $this->paymentMethod != "" ? 
                                PaymentMethod::where('name',$this->paymentMethod)->first()->id : null,
            'status' => $this->invoiceStatus,
            'received_amount' => $this->receivedAmount,
            'changed_amount' => $this->changedAmount
        ]);

        return redirect()->route('invoice')->with('success','Invoice Updated');
    }
}
