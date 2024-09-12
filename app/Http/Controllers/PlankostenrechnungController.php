<?php

namespace App\Http\Controllers;

use App\Models\Plankostenrechnung;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;

class PlankostenrechnungController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Abgrenzungsrechnung', [
            'items' => Plankostenrechnung::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'plankosten_variabel' => 'nullable',
                'plankosten_gesamt' => 'nullable',
                'istkosten' => 'nullable',
                'stueck_soll' => 'nullable',
                'stueck_ist' => 'nullable',
            ]);
    
            $r = Plankostenrechnung::create($request->all());
    
            return $r;
        } catch (Exception $e) {
            return response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Plankostenrechnung::destroy($id);
    
            return true;
        } catch (Exception $e) {
            return response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
