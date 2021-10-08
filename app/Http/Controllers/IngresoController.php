<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingreso;
use App\Models\Habitacion;
use App\Models\UbicacionHabitacion;
use App\Models\User;
use App\Models\Paciente;
use Redirect,Response;


class IngresoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-ingreso|crear-ingreso|editar-ingreso|borrar-ingreso', ['only'=>['index']]);
        $this->middleware('permission:crear-ingreso', ['only'=>['create','store']]);
        $this->middleware('permission:editar-ingreso', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-ingreso', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ingresos=DB::table('vistaingresados')->where('estado','Activo')->select('*')->paginate(5);
        return view('ingresos.index', compact('ingresos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pacientes=Paciente::paginate(5);
        $habitaciones=Habitacion::paginate(5);
        return view('ingresos.crear',compact('pacientes','habitaciones'));
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
        $this->validate($request, [
            'id_paciente'=>'required',
            'id_habitacion'=>'required',
        ]);

        $Ingreso=$request->all();

        $estado=DB::table('habitacion')->where('id_habitacion', $Ingreso['id_habitacion'])->select('estado','Precio_estadia_mensual','num_habi','id_ubicacion')->get();

        foreach ($estado as $esta) {
            $est= $esta->estado;
            $precio=$esta->Precio_estadia_mensual;
            $roomN=$esta->num_habi;
            $ubi=$esta->id_ubicacion;
        }

        $roomU=DB::table('ubi_habitacion')->where('id_ubicacion', $ubi)->select('ubicacion')->get();

        foreach ($roomU as $rou) {
            $ru=$rou->ubicacion;
        }

        $resss=DB::table('paciente')->where('id_paciente', $Ingreso['id_paciente'])->select('id_responsable')->get();

        foreach ($resss as $rss) {
            $respon=$rss->id_responsable;
        }

        $usuario=Auth::id();
        
        $paciente=DB::table('ingreso_asilo')->where('id_paciente', $Ingreso['id_paciente'])->select('*')->first();

        if($paciente==null){
            //print_r("el objeto esta vacio");
            $estPaciente = null;
            $idenPaciente = null;
        }else{
            $estPaciente = $paciente->estado;
            $idenPaciente =$paciente->id_paciente;
        }
       // print_r($estPaciente);
        //print_r($idenPaciente);
       // print_r($paciente);
        //print_r($est); 
        //print_r($precio); 

        if($est=='Vacio'){

            if($estPaciente=='Activo' && $idenPaciente == $request->input('id_paciente')){

                \Session::flash('flash_message','Este paciente ya se encuentra en el sistema');
                 return redirect()->route('ingresos.index');  
            }
            else if ($estPaciente=='Desactivado' && $idenPaciente == $request->input('id_paciente')){
                
                DB::table('ingreso_asilo')->where('id_paciente', $request->input('id_paciente'))->update([
                    'fecha_ingreso'=>DB::raw('now()'),
                    'estado'=>'Activo'
                ]);

                DB::table('habitacion')->where('id_habitacion', $request->input('id_habitacion'))->update([
                    'estado'=>'Medio Lleno'
                ]);

                \Session::flash('flash_message','Paciente Activado con Exito');
                 return redirect()->route('ingresos.index');  

            }
            else if  ($paciente==null){

                DB::table('ingreso_asilo')->insert([
                    'id_paciente'=>$request->input('id_paciente'),
                    'id_habitacion'=>$request->input('id_habitacion'),
                    'fecha_ingreso'=>DB::raw('now()'),
                    'fecha_modificacion'=>DB::raw('now()'),
                    'fecha_retiro'=>NULL,
                    'Total_Pagar'=>$precio,
                    'id_usuario'=>$usuario,
                    'estado'=>'Activo'
                ]);
    
                DB::table('habitacion')->where('id_habitacion', $request->input('id_habitacion'))->update([
                    'estado'=>'Medio Lleno'
                ]); 

                DB::table('cuenta_paciente')->insert([
                    'id_responsable'=>$respon,
                    'saldo'=>$precio,
                    'estado'=>'Activo',
                    'fecha_ingreso'=>DB::raw('now()'),
                    'fecha_modificacion'=>DB::raw('now()'),
                    'fecha_retiro'=>NULL
                ]);

                return redirect()->route('ingresos.index'); 
            } 
        }
        else if ($est=='Medio Lleno'){
         
            if($estPaciente=='Activo' && $idenPaciente == $request->input('id_paciente')){

                \Session::flash('flash_message','Este paciente ya se encuentra en el sistema');
                 return redirect()->route('ingresos.index');  
            }
            else if ($estPaciente=='Desactivado' && $idenPaciente == $request->input('id_paciente')){

                DB::table('ingreso_asilo')->where('id_paciente', $request->input('id_paciente'))->update([
                    'fecha_ingreso'=>DB::raw('now()'),
                    'estado'=>'Activo'
                ]);

                DB::table('habitacion')->where('id_habitacion', $request->input('id_habitacion'))->update([
                    'estado'=>'Lleno'
                ]);

                \Session::flash('flash_message','Paciente Activado con Exito');
                 return redirect()->route('ingresos.index');  

            }
            else if  ($paciente==null){

                DB::table('ingreso_asilo')->insert([
                    'id_paciente'=>$request->input('id_paciente'),
                    'id_habitacion'=>$request->input('id_habitacion'),
                    'fecha_ingreso'=>DB::raw('now()'),
                    'fecha_modificacion'=>DB::raw('now()'),
                    'fecha_retiro'=>NULL,
                    'Total_Pagar'=>$precio,
                    'id_usuario'=>$usuario,
                    'estado'=>'Activo'
                ]);
    
                DB::table('habitacion')->where('id_habitacion', $request->input('id_habitacion'))->update([
                    'estado'=>'Lleno'
                ]);

                DB::table('cuenta_paciente')->insert([
                    'id_responsable'=>$respon,
                    'saldo'=>$precio,
                    'estado'=>'Activo',
                    'fecha_ingreso'=>DB::raw('now()'),
                    'fecha_modificacion'=>DB::raw('now()'),
                    'fecha_retiro'=>NULL
                ]);

                return redirect()->route('ingresos.index'); 
            }
        }
        else if ($est=='Lleno'){
            if($estPaciente=='Activo' && $idenPaciente == $request->input('id_paciente')){

                \Session::flash('flash_message','Este paciente ya se encuentra en La habitación No. '.$roomN.' del '.$ru.'');
                 return redirect()->route('ingresos.index');  
            }
            else if ($estPaciente=='Desactivado' && $idenPaciente == $request->input('id_paciente')){
                
                \Session::flash('flash_message','La habitación No. '.$roomN.' del '.$ru.' ya se encuentra llena porfavor eliga otra');
                 return redirect()->route('ingresos.index');
            }
            else if  ($paciente==null){
                
                \Session::flash('flash_message','La habitación No. '.$roomN.' del '.$ru.' ya se encuentra llena porfavor eliga otra');
                return redirect()->route('ingresos.index');
            }
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
    public function edit(Ingreso $ingresos)
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
    public function destroy(Ingreso $ingreso)
    {
        //
    }
}
