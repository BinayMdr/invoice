<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return view('pages.inventory.index');
    }

    public function create()
    {
        $inventory = null;
        return view('pages.inventory.edit-create',compact('inventory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'total'=> 'required'
        ]);

        if(Inventory::where('name',$request->name)->get()->count() > 0)  return redirect()->back()->with('error','Item name already exist');

        if($request->total < 0) return redirect()->back()->with('error','Total item must be equal or more than 0');
        
        Inventory::create([
            'name' => $request->name,
            'total' => $request->total
        ]);

        return redirect()->route('inventory')->with('success','Inventory created');
    }

    public function edit(Inventory $inventory)
    {
        return view('pages.inventory.edit-create',compact('inventory'));
    }

    public function update(Request $request,Inventory $inventory)
    {
        $request->validate([
            'name' => 'required',
            'total' => 'required'
        ]);

        if(Inventory::whereNotIn('id',[$inventory->id])->where('name',$request->name)->get()->count() > 0)  return redirect()->back()->with('error','Item name already exist');

        if($request->total < 1) return redirect()->back()->with('error','Total item must be equal or more than 0');

        $inventory->update([
            'name' => $request->name,
            'total' => $request->total
        ]);

        return redirect()->route('inventory')->with('success','Inventory updated');
    }
}
