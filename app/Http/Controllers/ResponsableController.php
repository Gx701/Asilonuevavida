<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Responsable;
use App\Models\Parentesco;

class ResponsableController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-responsable|crear-responsable|editar-responsable|borrar-responsable', ['only'=>['index']]);
        $this->middleware('permission:crear-responsable', ['only'=>['create','store']]);
        $this->middleware('permission:editar-responsable|editar-parentesco', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-responsable', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $responsables=DB::table('vistaresponsable')->where('estado','Activo')->select('*')->paginate(5);
        return view('responsables.index', compact('responsables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parentescos=Parentesco::paginate(5);
        return view('responsables.crear',compact('parentescos'));
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
            'nombre_res_1'=>'required',
            'nombre_res_2'=>'required',
            'apellido_res_1'=>'required',
            'apellido_res_2'=>'required',
            'dpi_res'=>'required|numeric|max:99999999999999',
            'nit_res'=>'required|numeric|max:99999999',
            'fecha_nacimiento'=>'required',
            'direccion'=>'required',
            'telefono_res'=>'required|numeric|max:99999999',
            'telefono_res2'=>'required|numeric|max:99999999',
            'imagen'=>'required|image|mimes:jpeg,png,svg|max:1024',
            'id_parentesco'=>'required'
        ]);

        $Responsable=$request->all();

        if($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'img/';
            $imagenResponsable = date('YmdHis'). "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenResponsable);
            $Responsable['imagen'] = "$imagenResponsable";             
        }
        
        DB::table('responsable')->insert([
            'nombre_res_1'=>$request->input('nombre_res_1'),
            'nombre_res_2'=>$request->input('nombre_res_2'),
            'apellido_res_1'=>$request->input('apellido_res_1'),
            'apellido_res_2'=>$request->input('apellido_res_2'),
            'dpi_res'=>$request->input('dpi_res'),
            'nit_res'=>$request->input('nit_res'),
            'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
            'direccion'=>$request->input('direccion'),
            'telefono_res'=>$request->input('telefono_res'),
            'telefono_res2'=>$request->input('telefono_res2'),
            'id_parentesco'=>$request->input('id_parentesco'),
            'fecha_ingreso'=>DB::raw('now()'),
            'fecha_modificacion'=>DB::raw('now()'),
            'fecha_retiro'=>NULL,
            'foto_responsable'=>$Responsable['imagen'],
            'estado'=>'Activo'
        ]);
        
        return redirect()->route('responsables.index');
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
    public function edit(Responsable $responsable)
    {
        //
        $parentescos=Parentesco::paginate(5);
        return view('responsables.editar',compact('responsable','parentescos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responsable $responsable)
    {
        //
        $this->validate($request, [
            'nombre_res_1'=>'required',
            'nombre_res_2'=>'required',
            'apellido_res_1'=>'required',
            'apellido_res_2'=>'required',
            'dpi_res'=>'required|numeric|max:99999999999999',
            'nit_res'=>'required|numeric|max:99999999',
            'fecha_nacimiento'=>'',
            'direccion'=>'required',
            'telefono_res'=>'required|numeric|max:99999999',
            'telefono_res2'=>'required|numeric|max:99999999',
            'imagen'=>'required|image|mimes:jpeg,png,svg|max:1024',
            'id_parentesco'=>''
        ]);

        $res=$request->all();

        if($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'img/';
            $imagenResponsable = date('YmdHis'). "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenResponsable);
            $res['imagen'] = "$imagenResponsable";             
        }else{
            unset($res['imagen']);
            $res['imagen']="";
        }

        $valParentesco =$request->input('id_parentesco');

       if($valParentesco=="" && $res['imagen']=="" && $res['fecha_nacimiento']==""){
            DB::table('responsable')->where('id_responsable', $responsable['id_responsable'])->update([
                'nombre_res_1'=>$request->input('nombre_res_1'),
                'nombre_res_2'=>$request->input('nombre_res_2'),
                'apellido_res_1'=>$request->input('apellido_res_1'),
                'apellido_res_2'=>$request->input('apellido_res_2'),
                'dpi_res'=>$request->input('dpi_res'),
                'nit_res'=>$request->input('nit_res'),
                'direccion'=>$request->input('direccion'),
                'telefono_res'=>$request->input('telefono_res'),
                'telefono_res2'=>$request->input('telefono_res2'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valParentesco>0 && $res['imagen']=="" && $res['fecha_nacimiento']=="") {
            DB::table('responsable')->where('id_responsable', $responsable['id_responsable'])->update([
                'nombre_res_1'=>$request->input('nombre_res_1'),
                'nombre_res_2'=>$request->input('nombre_res_2'),
                'apellido_res_1'=>$request->input('apellido_res_1'),
                'apellido_res_2'=>$request->input('apellido_res_2'),
                'dpi_res'=>$request->input('dpi_res'),
                'nit_res'=>$request->input('nit_res'),
                'direccion'=>$request->input('direccion'),
                'telefono_res'=>$request->input('telefono_res'),
                'telefono_res2'=>$request->input('telefono_res2'),
                'fecha_modificacion'=>DB::raw('now()'),
                'id_parentesco'=>$request->input('id_parentesco')
            ]);
        }
        else if($valParentesco>0 && $res['imagen']>0 && $res['fecha_nacimiento']==""){
            DB::table('responsable')->where('id_responsable', $responsable['id_responsable'])->update([
                'nombre_res_1'=>$request->input('nombre_res_1'),
                'nombre_res_2'=>$request->input('nombre_res_2'),
                'apellido_res_1'=>$request->input('apellido_res_1'),
                'apellido_res_2'=>$request->input('apellido_res_2'),
                'dpi_res'=>$request->input('dpi_res'),
                'nit_res'=>$request->input('nit_res'),
                'direccion'=>$request->input('direccion'),
                'telefono_res'=>$request->input('telefono_res'),
                'telefono_res2'=>$request->input('telefono_res2'),
                'id_parentesco'=>$request->input('id_parentesco'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_responsable'=>$res['imagen']
            ]);
        }
        else if($valParentesco>0 && $res['imagen']>0 && $res['fecha_nacimiento']>0){
            DB::table('responsable')->where('id_responsable', $responsable['id_responsable'])->update([
                'nombre_res_1'=>$request->input('nombre_res_1'),
                'nombre_res_2'=>$request->input('nombre_res_2'),
                'apellido_res_1'=>$request->input('apellido_res_1'),
                'apellido_res_2'=>$request->input('apellido_res_2'),
                'dpi_res'=>$request->input('dpi_res'),
                'nit_res'=>$request->input('nit_res'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_res'=>$request->input('telefono_res'),
                'telefono_res2'=>$request->input('telefono_res2'),
                'id_parentesco'=>$request->input('id_parentesco'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_responsable'=>$res['imagen']
            ]);
        }
        else if($valParentesco=="" && $res['imagen']>0 && $res['fecha_nacimiento']>0){
            DB::table('responsable')->where('id_responsable', $responsable['id_responsable'])->update([
                'nombre_res_1'=>$request->input('nombre_res_1'),
                'nombre_res_2'=>$request->input('nombre_res_2'),
                'apellido_res_1'=>$request->input('apellido_res_1'),
                'apellido_res_2'=>$request->input('apellido_res_2'),
                'dpi_res'=>$request->input('dpi_res'),
                'nit_res'=>$request->input('nit_res'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_res'=>$request->input('telefono_res'),
                'telefono_res2'=>$request->input('telefono_res2'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_responsable'=>$res['imagen']
            ]);
        }
        else if($valParentesco=="" && $res['imagen']=="" && $res['fecha_nacimiento']>0){
            DB::table('responsable')->where('id_responsable', $responsable['id_responsable'])->update([
                'nombre_res_1'=>$request->input('nombre_res_1'),
                'nombre_res_2'=>$request->input('nombre_res_2'),
                'apellido_res_1'=>$request->input('apellido_res_1'),
                'apellido_res_2'=>$request->input('apellido_res_2'),
                'dpi_res'=>$request->input('dpi_res'),
                'nit_res'=>$request->input('nit_res'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_res'=>$request->input('telefono_res'),
                'telefono_res2'=>$request->input('telefono_res2'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valParentesco=="" && $res['imagen']>0 && $res['fecha_nacimiento']==""){
            DB::table('responsable')->where('id_responsable', $responsable['id_responsable'])->update([
                'nombre_res_1'=>$request->input('nombre_res_1'),
                'nombre_res_2'=>$request->input('nombre_res_2'),
                'apellido_res_1'=>$request->input('apellido_res_1'),
                'apellido_res_2'=>$request->input('apellido_res_2'),
                'dpi_res'=>$request->input('dpi_res'),
                'nit_res'=>$request->input('nit_res'),
                'direccion'=>$request->input('direccion'),
                'telefono_res'=>$request->input('telefono_res'),
                'telefono_res2'=>$request->input('telefono_res2'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_responsable'=>$res['imagen']
            ]);
        }

        return redirect()->route('responsables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responsable $responsable)
    {
        //
        DB::table('responsable')->where('id_responsable', $responsable['id_responsable'])->update([
            'fecha_retiro'=>DB::raw('now()'),
            'estado'=>'Desactivado'
        ]);
        return redirect()->route('responsables.index');
    }
}
