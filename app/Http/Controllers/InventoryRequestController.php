<?php

namespace App\Http\Controllers;

use App\Models\InventoryRequest;
use Illuminate\Http\Request;

class InventoryRequestController extends Controller
{
    public function index()
    {
        return view('pages.inventory-request.index');
    }

    public function create()
    {
        $inventoryRequest = null;
        return view('pages.inventory-request.edit-create',compact('inventoryRequest'));
    }

    public function edit(InventoryRequest $inventoryRequest)
    {
        return view('pages.inventory-request.edit-create',compact('inventoryRequest'));
    }
}
