<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('facturas.index');
    }

    public function facturaDatables()
    {
        switch (Auth::user()->rol) {
            case 'Administrador':
                return DataTables::eloquent(Factura::orderBy('estado', 'desc'))
                                ->addColumn('btn', 'facturas.actions')
                                ->rawColumns(['btn'])
                                ->toJson();
                break;
            case 'Proveedor':
                return DataTables::eloquent(Factura::orderBy('created_at', 'asc')->where('usuario_id', Auth::user()->id))
                                ->addColumn('btn', 'facturas.actions')
                                ->rawColumns(['btn'])
                                ->toJson();
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('facturas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $datos = $request->all();

        $validated = $request->validate([
            'concepto' => 'required|string',
            'factura' => 'required|mimes:pdf',
            'xml' => 'required',
        ]);

        if($request->hasFile('factura'))
        {
            $hora = Str::slug(date('h:i:s A'),'_');
            $factura = $request->file('factura');
            $facturaNombre = $hora.'_'.$factura->getClientOriginalName();
            $datos['factura'] = $request->file('factura')->storeAs('uploads/facturas', $facturaNombre, 'public');
        }
        if($request->hasFile('xml'))
        {
            $hora = Str::slug(date('h:i:s A'),'_');
            $xml = $request->file('xml');
            $xmlNombre = $hora.'_'.$xml->getClientOriginalName();
            $datos['xml'] = $request->file('xml')->storeAs('uploads/xmls', $xmlNombre, 'public');
        }

        $datos['usuario_id'] = Auth::user()->id;

        Factura::create($datos);

        return redirect()->route('facturas.index')->with('status','Factura creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
