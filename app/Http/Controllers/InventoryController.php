<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(): View
    {
        //get all inventory
        $inventory = Inventory::all();
        return view('inventory.index', ['inventory' => $inventory]);
    }
    public function edit($id): View
    {
        //get inventory by id
        $inventory = Inventory::find($id);
        return view('inventory.edit', ['inventory' => $inventory]);
    }
    public function destroy($id): RedirectResponse
    {
        //delete inventory by id
        $inventory = Inventory::find($id);
        $inventory->delete();
        return redirect()->route('inventory.index');
    }
    public function create(): View
    {
        //create inventory
        return view('inventory.create');
    }
    public function store(Request $request): RedirectResponse
    {
        //store inventory
        $inventory = new Inventory();
        $inventory->name = $request->name;
        $inventory->description = $request->description;
        $inventory->price = $request->price;
        $inventory->quantity = $request->quantity;
        $inventory->category = $request->category;
        $inventory->user_id = $request->user_id;
        $inventory->save();
        return redirect()->route('inventory.index');
    }
    public function update(Request $request, $id): RedirectResponse
    {
        //update inventory
        $inventory = Inventory::find($id);
        $inventory->name = $request->name;
        $inventory->description = $request->description;
        $inventory->price = $request->price;
        $inventory->quantity = $request->quantity;
        $inventory->category = $request->category;
        $inventory->user_id = $request->user_id;
        $inventory->save();
        return redirect()->route('inventory.index');
    }
    public function search(Request $request): JsonResponse
    {
        //search inventory
        $inventory = Inventory::where('name', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%')
            ->orWhere('price', 'like', '%' . $request->search . '%')
            ->orWhere('quantity', 'like', '%' . $request->search . '%')
            ->orWhere('category', 'like', '%' . $request->search . '%')
            ->get();
        //return a json response
        return response()->json($inventory);
    }

    public function get(Request $request): JsonResponse
    {
        //get inventory
        if ($request->search != 'all') {
            $inventory = Inventory::where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('price', 'like', '%' . $request->search . '%')
                ->orWhere('quantity', 'like', '%' . $request->search . '%')
                ->orWhere('category', 'like', '%' . $request->search . '%')
                ->orderBy($request->sort, $request->direction)
                ->get();
        } else {
            $inventory = Inventory::orderBy($request->sort, $request->direction)->get();
        }
        //return a json response
        return response()->json($inventory);
    }
}
