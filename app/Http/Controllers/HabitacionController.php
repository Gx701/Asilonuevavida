<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Habitacion;
use App\Models\UbicacionHabitacion;

class HabitacionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-habitacion|crear-habitacion|editar-habitacion|borrar-habitacion', ['only'=>['index']]);
        $this->middleware('permission:crear-habitacion', ['only'=>['create','store']]);
        $this->middleware('permission:editar-habitacion', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-habitacion', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $habitaciones=DB::table('vistahabitaciones')->where('estado','Lleno')->orWhere('estado','Medio Lleno')->orWhere('estado','Vacio')->select('*')->paginate(5);
        return view('habitaciones.index', compact('habitaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $ubicaciones=UbicacionHabitacion::paginate(5);
        return view('habitaciones.crear',compact('ubicaciones'));
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
            'num_habi'=>'required',
            'id_ubicacion'=>'required',
            'Precio_estadia_mensual'=>'required'
        ]);

        DB::table('habitacion')->insert([
            'num_habi'=>$request->input('num_habi'),
            'id_ubicacion'=>$request->input('id_ubicacion'),
            'Precio_estadia_mensual'=>$request->input('Precio_estadia_mensual'),
            'fecha_ingreso'=>DB::raw('now()'),
            'fecha_modificacion'=>DB::raw('now()'),
            'fecha_retiro'=>NULL,
            'estado'=>'Vacio'
        ]);
        
        return redirect()->route('habitaciones.index');
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
    public function edit(Habitacion $habitacione)
    {
        //
        $ubicaciones=UbicacionHabitacion::paginate(5);
        return view('habitaciones.editar',compact('habitacione','ubicaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Habitacion $habitacion)
    {
        //
        $this->validate($request, [
            'num_habi'=>'required',
            'id_ubicacion'=>'required',
            'Precio_estadia_mensual'=>'required'
        ]);

        $valUbicacion =$request->input('id_ubicacion');

        if($valUbicacion==""){
            DB::table('habitacion')->where('id_habitacion', $habitacion['id_habitacion'])->update([
                'num_habi'=>$request->input('num_habi'),
                'Precio_estadia_mensual'=>$request->input('Precio_estadia_mensual'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if ($valUbicacion=="">0){
            DB::table('habitacion')->where('id_habitacion', $habitacion['id_habitacion'])->update([
                'num_habi'=>$request->input('num_habi'),
                'id_ubicacion'=>$request->input('id_ubicacion'),
                'Precio_estadia_mensual'=>$request->input('Precio_estadia_mensual'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        return redirect()->route('habitaciones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Habitacion $habitacione)
    {
        //
        DB::table('habitacion')->where('id_habitacion', $habitacione['id_habitacion'])->update([
            'fecha_retiro'=>DB::raw('now()'),
            'estado'=>'Desactivado'
        ]);
        return redirect()->route('habitaciones.index');
    }
}
