<?php

namespace App\Http\Controllers;

use App\Models\Preisuntergrenzen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;

class PreisuntergrenzenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Preisuntergrenze', [
            'items' => Preisuntergrenzen::all(),
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
                'stueckZahl' => 'nullable|numeric',
                'varKostenProStueck' => 'nullable|numeric',
                'fixkosten' => 'nullable|numeric',
                'kurzPreisUG' => 'nullable|numeric',
                'langPreisUG' => 'nullable|numeric',
            ]);
    
            $r = Preisuntergrenzen::create($request->all());
    
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
            Preisuntergrenzen::destroy($id);
    
            return true;
        } catch (Exception $e) {
            return response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPreisuntergrenze() 
    {
        try {
            $data = Preisuntergrenzen::all();
            return response()->json([$data], HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
