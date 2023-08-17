<?php

namespace App\Http\Livewire;

use App\Models\Inventory;
use App\Models\InventoryRequest;
use App\Models\InventoryRequestItem;
use Livewire\Component;

class InventoryRequestCreateUpdateComponent extends Component
{
    public $productLists = [];
    public $productName = "";
    public $productNameList = [];
    public $type ;
    public $inventoryRequestId = null;
    public $inventoryRequestStatus = null;
    protected $listeners = ['productAdded','updateInventoryRequestStatus'];

    public function mount($type,$inventory_request_id)
    {
        $this->type = $type;
        if($type == "Update")
        {
            $this->inventoryRequestId = $inventory_request_id;
            $inventoryRequest = InventoryRequest::find($inventory_request_id);
            $this->inventoryRequestStatus = $inventoryRequest->status;

            foreach(InventoryRequestItem::where('inventory_request_id',$inventory_request_id)->get() as $product)
            {
                $item_array = [
                    'id' => $product->inventory_id,
                    'name' => Inventory::find($product->inventory_id)->name,
                    'quantity' => $product->quantity,
                    'max_quantity' => $product->total
                ];
    
                array_push($this->productLists,$item_array);
            }
            
        }
        $this->productNameList = Inventory::orderby('name','ASC')->get();
    }
    public function render()
    {
        return view('livewire.inventory-request-create-update-component');
    }

    public function productAdded($id)
    {
        $item = Inventory::find($id);
        
        if(!is_null($item))
        {
            $item_array = [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => '1',
                'max_quantity' => $item->total
            ];

            array_push($this->productLists,$item_array);
            $this->updateProductList();
        }   
    }

    public function updateQuantity($itemNumber,$type,$max_quantity)
    {
        $previousQuantity = $this->productLists[$itemNumber]['quantity'];
        $newQuantity = $previousQuantity;
        
        if($type == "add") 
        {
            if($previousQuantity < $max_quantity) $newQuantity = $previousQuantity + 1;
        }
        else if($previousQuantity > 1) $newQuantity = $previousQuantity - 1;
        
        $this->productLists[$itemNumber]['quantity'] = $newQuantity;
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
                    'quantity' => $product['quantity']
                ];
    
                array_push($itemList,$item_array);
            }
        }

        $this->productLists = $itemList;
    }

    public function updateProductList()
    {
        if(count($this->productLists) > 0)
        {
            $idList = array_column($this->productLists,'id');
            $this->productNameList = Inventory::whereNotIn('id',$idList)->orderby('name','ASC')->get();
        }
    }


    public function save()
    {
        $inventoryRequest = new InventoryRequest();
        $inventoryRequest->branch_id = \Auth::user()->branch;
        $inventoryRequest->user_id = \Auth::user()->id;
        $inventoryRequest->status = "Pending";
        $inventoryRequest->save();

        foreach($this->productLists as $product)
        {
            $inventoryRequestItem = new InventoryRequestItem();
            $inventoryRequestItem->inventory_request_id = $inventoryRequest->id;
            $inventoryRequestItem->inventory_id = $product['id'];
            $inventoryRequestItem->quantity = $product['quantity'];
            $inventoryRequestItem->save();
        }

        return redirect()->route('inventory-request')->with('success','Inventory Request Created');
    }

    public function update()
    {
        $inventoryRequest = InventoryRequest::find($this->inventoryRequestId);

        if($this->inventoryRequestStatus == "Completed")
        {
            foreach(InventoryRequestItem::where('inventory_request_id',$this->inventoryRequestId)->get() as $product)
            {
                $inventory = Inventory::find($product->inventory_id);
                if($product->quantity > $inventory->total) return redirect()->route('inventory-request')->with('error','Requested Item is higher than the quantity present in inventory');
            }
        }

        $inventoryRequest->update([
            'status' => $this->inventoryRequestStatus
        ]);

        if($this->inventoryRequestStatus == "Completed")
        {
            foreach(InventoryRequestItem::where('inventory_request_id',$this->inventoryRequestId)->get() as $product)
            {
                $inventory = Inventory::find($product->inventory_id);
                $inventory->update([
                    "total" => $inventory->total - $product->quantity
                ]); 
            }
        }

        return redirect()->route('inventory-request')->with('success','Inventory Request Updated');
    }

    public function updateInventoryRequestStatus($name)
    {
        $this->inventoryRequestStatus = $name;
    }

}
