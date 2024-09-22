<?php

namespace App\Http\Controllers;

use App\Models\BreakEvens;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;

class BreakEvensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('BreakEven', [
            'items' => BreakEvens::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'stueckPreis' => 'nullable|decimal',
                'geplantePMenge' => 'nullable|integer',
                'KTZrechnung' => 'nullable|decimal',
                'deckungsBeitrag' => 'nullable|decimal',
                'varKosten' => 'nullable|decimal',
                'fixkosten' => 'nullable|decimal',
                'opErgebnis' => 'nullable|decimal',
            ]);
    
            $r = BreakEvens::create($request->all());
    
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
            BreakEvens::destroy($id);
    
            return true;
        } catch (Exception $e) {
            return response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
