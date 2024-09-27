<?php

namespace App\Http\Controllers;

use App\Models\Deckungsbeitragrechnungen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;

class DeckungsbeitragController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Deckungsbeitragrechnung', [
            'items' => Deckungsbeitragrechnungen::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string',
                'preisProStueck' => 'nullable|numeric',
                'stueckZahl' => 'nullable|numeric',
                'varKostenProStueck' => 'nullable|numeric',
                'fixkosten' => 'nullable|numeric',
                'deckungsBeitrag' => 'nullable|numeric',
                'gewinn' => 'nullable|numeric',
            ]);
    
            $r = Deckungsbeitragrechnungen::create($request->all());
    
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
            Deckungsbeitragrechnungen::destroy($id);
    
            return true;
        } catch (Exception $e) {
            return response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getDeckungsbeitragsrechnungen() 
    {
        try {
            $data = Deckungsbeitragrechnungen::all();
            return response()->json([$data], HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
