<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Horario;
use App\Models\HorarioDetalle;
use App\Models\Turno;
use App\Models\Dia;

class HorarioController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-horario|crear-horario|editar-horario|borrar-horario', ['only'=>['index']]);
        $this->middleware('permission:crear-horario', ['only'=>['create','store']]);
        $this->middleware('permission:editar-horario', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-horario', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $horarios=DB::table('vistahorarios')->select('*')->paginate(5);
        return view('horarios.index', compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dias = Dia::get();
        $turnos = Turno::get();
        return view('horarios.crear', compact('dias', 'turnos'));
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
        $input = $request->all();
        try{
    		DB::beginTransaction();
    		$horarios=new Horario;
        	$horarios->descripcion='Nuevo Ingreso';

            $id_d=$request->get('dia_id');
            $id_t=$request->get('turno_id');
        	$conteo = 0;

        	while($conteo < count($id_d)){
        		$detalle =new HorarioDetalle();
        		$detalle->id_horario=$horarios->id_horario;
        		$detalle->id_turno=$id_t[$conteo];
        		$detalle->id_dia=$id_d[$conteo];
        		$detalle->save();
        		$conteo=$conteo+1;

        	}
    		DB::commit();

    	}catch(\Exception $e)
    	{
    		DB::rollback();
            print_r($e);
    	}
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
