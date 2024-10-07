<?php

namespace App\Http\Controllers;

use App\Models\TabelleAbweichungsanalysen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;

class TabelleAbweichungsanalysenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('AbweichungsanalyseTabelle', [
            'items' => TabelleAbweichungsanalysen::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'varSummeKosten' => 'nullable|numeric',
                'geplanteLeistung' => 'nullable|numeric',
                'IstLeistung' => 'nullable|numeric',
                'SummeIstKosten' => 'nullable|numeric',
                'verrechneteLeistungGesamt' => 'nullable|numeric',
                'varPlanverrechnungssatz' => 'nullable|numeric',
                'gesPlanverrechnungssatz' => 'nullable|numeric',
                'verrechneteLeistungIst' => 'nullable|numeric',
                'abweichung' => 'nullable|numeric',
                'IstKostensatz' => 'nullable|numeric',
            ]);
    
            $r = TabelleAbweichungsanalysen::create($request->all());
    
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
            TabelleAbweichungsanalysen::destroy($id);
    
            return true;
        } catch (Exception $e) {
            return response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAbweichungsrechnungTabelle() 
    {
        try {
            $data = TabelleAbweichungsanalysen::all();
            return response()->json([$data], HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
