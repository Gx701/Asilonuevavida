<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Turno;

class TurnoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-turno|crear-turno|editar-turno|borrar-turno', ['only'=>['index']]);
        $this->middleware('permission:crear-turno', ['only'=>['create','store']]);
        $this->middleware('permission:editar-turno', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-turno', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $turnos=DB::table('turno')->select('*')->paginate(5);
        return view('turnos.index', compact('turnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('turnos.crear');
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
            'hora_inicio_m'=>'required',
            'hora_salida_m'=>'required',
            'hora_inicio_t'=>'required',
            'hora_salida_t'=>'required'
        ]);

        $Turno=$request->all();

        DB::table('turno')->insert([
            'hora_inicio_m'=>$request->input('hora_inicio_m'),
            'hora_salida_m'=>$request->input('hora_salida_m'),
            'hora_inicio_t'=>$request->input('hora_inicio_t'),
            'hora_salida_t'=>$request->input('hora_salida_t'),
        ]);

        return redirect()->route('turnos.index');
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
    public function edit(Turno $turno)
    {
        //
        return view('turnos.editar', compact('turno'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Turno $turno)
    {
        //
        $this->validate($request, [
            'hora_inicio_m'=>'',
            'hora_salida_m'=>'',
            'hora_inicio_t'=>'',
            'hora_salida_t'=>''
        ]);

        $turn=$request->all();

       /* print_r($turn['hora_inicio_m']);
        print_r($turn['hora_salida_m']);
        print_r($turn['hora_inicio_t']);
        print_r($turn['hora_salida_t']);*/

        $im=$turn['hora_inicio_m'];
        $sm=$turn['hora_salida_m'];
        $it=$turn['hora_inicio_t'];
        $st=$turn['hora_salida_t'];

        if($im==null && $sm==null && $it==null && $st==null){
            \Session::flash('flash_message','No se realizo ningun cambio');
            return redirect()->route('turnos.index');
        }
        else if ($im>0 && $sm==null && $it==null && $st==null){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_inicio_m'=>$im
            ]);
        }
        else if ($im>0 && $sm>0 && $it==null && $st==null){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_inicio_m'=>$im,
                'hora_salida_m'=>$sm
            ]);
        }
        else if ($im>0 && $sm>0 && $it>0 && $st==null){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_inicio_m'=>$im,
                'hora_salida_m'=>$sm,
                'hora_inicio_t'=>$it
            ]);
        }
        else if ($im>0 && $sm>0 && $it>0 && $st>0){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_inicio_m'=>$im,
                'hora_salida_m'=>$sm,
                'hora_inicio_t'=>$it,
                'hora_salida_t'=>$st
            ]);
        }
        else if ($im==null && $sm>0 && $it==null && $st==null){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_salida_m'=>$sm
            ]);
        }
        else if ($im==null && $sm>0 && $it>0 && $st==null){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_salida_m'=>$sm,
                'hora_inicio_t'=>$it
            ]);
        }
        else if ($im==null && $sm>0 && $it>0 && $st>0){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_salida_m'=>$sm,
                'hora_inicio_t'=>$it,
                'hora_salida_t'=>$st
            ]);
        }
        else if ($im==null && $sm==null && $it>0 && $st==null){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_inicio_t'=>$it
            ]);
        }
        else if ($im==null && $sm==null && $it>0 && $st>0){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_inicio_t'=>$it,
                'hora_salida_t'=>$st
            ]);
        }
        else if ($im==null && $sm==null && $it==null && $st>0){
            DB::table('turno')->where('id_turno', $turno->id_turno)->update([
                'hora_salida_t'=>$st
            ]);
        }
        \Session::flash('flash_message','Turno Actualizado correctamente');
        return redirect()->route('turnos.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Turno $turno)
    {
        //
        Turno::find($Turno->id_turno)->delete();
        return redirect()->route('turnos.index');
    }
}
