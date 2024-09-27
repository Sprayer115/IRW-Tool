<?php

namespace App\Http\Controllers;

use App\Models\Abweichungsanalysen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;

class AbweichungsanalysenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Abweichungsanalyse', [
            'items' => Abweichungsanalysen::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'beschaeftAbweichung' => 'nullable|integer',
                'fixkosten' => 'nullable|integer',
                'gesamtabweichung' => 'nullable|integer',
                'istKosten' => 'nullable|integer',
                'istKostenVerechneteLeistung' => 'nullable|integer',
                'istLeistung' => 'nullable|integer',
                'sollKosten' => 'nullable|integer',
                'varPlanverrechnungssatz' => 'nullable|integer',
                'verbrauchsabweichung' => 'nullable|integer',
            ]);
    
            $r = Abweichungsanalysen::create($request->all());
    
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
            Abweichungsanalysen::destroy($id);
    
            return true;
        } catch (Exception $e) {
            return response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAbweichungsrechnung() 
    {
        try {
            $data = Abweichungsanalysen::all();
            return response()->json([$data], HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
