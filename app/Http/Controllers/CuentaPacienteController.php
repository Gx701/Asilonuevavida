<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CuentaPaciente;
use App\Models\CuentaPacienteDetalle;

class CuentaPacienteController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cuenta|crear-cuenta|editar-cuenta|borrar-cuenta', ['only'=>['index']]);
        $this->middleware('permission:crear-cuenta', ['only'=>['create','store']]);
        $this->middleware('permission:editar-cuenta', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-cuenta', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cuentas=DB::table('vistacuentas')->where('estado','Activo')->select('*')->paginate(5);
        return view('cuentas.index', compact('cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $cuentasdetalles=DB::table('vistacuentasdetalles')->where('id_cuenta',$id)->latest('fecha_movimiento')->select('*')->paginate(5);
        return view('cuentas.detalles',compact('cuentasdetalles'));
        //dd($cuentasdetalles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CuentaPacienteDetalles $detalle)
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
