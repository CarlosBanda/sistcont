<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;

class InventoryMovementController extends Controller
{
    public function index()
    {
        $movements = InventoryMovement::with([
            'inventory.product',
            'user'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return view(
            'template.inventory.movements',
            compact('movements')
        );
    }

    public function show($id)
    {
        $movement = InventoryMovement::with([
            'inventory.product',
            'user'
        ])->findOrFail($id);

        return response()->json($movement);
    }
}