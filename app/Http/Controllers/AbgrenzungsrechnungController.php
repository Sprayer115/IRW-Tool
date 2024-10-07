<?php

namespace App\Http\Controllers;

use App\Models\Abgrenzungsrechnung as ModelsAbgrenzungsrechnung;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;

class AbgrenzungsrechnungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Abgrenzungsrechnung', [
            'items' => ModelsAbgrenzungsrechnung::all(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'aufwand' => 'nullable',
                'zeitliche_abgrenzung' => 'nullable',
                'za_aw' => 'nullable',
                'sachliche_abgrenzung' => 'nullable',
                'kosten' => 'nullable',
                'zeitraum' => 'nullable',
            ]);
    
            $r = ModelsAbgrenzungsrechnung::create($request->all());
    
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
            ModelsAbgrenzungsrechnung::destroy($id);
    
            return true;
        } catch (Exception $e) {
            return response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
