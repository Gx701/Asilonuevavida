<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;
use App\Models\Responsable;
use App\Models\Religion;
use App\Models\TipoSangre;

class PacienteController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-paciente|crear-paciente|editar-paciente|borrar-paciente', ['only'=>['index']]);
        $this->middleware('permission:crear-paciente', ['only'=>['create','store']]);
        $this->middleware('permission:editar-paciente', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-paciente', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pacientes=DB::table('vistapaciente')->where('estado','Activo')->select('*')->paginate(5);
        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $religiones=Religion::paginate(5);
        $sangres=TipoSangre::paginate(5);
        $responsables=Responsable::paginate(5);
        return view('pacientes.crear',compact('religiones','sangres','responsables'));
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
            'nombre_pa_1'=>'required',
            'nombre_pa_1'=>'required',
            'apellido_pa_1'=>'required',
            'apellido_ma_2'=>'required',
            'dpi_pa'=>'required|numeric|max:99999999999999',
            'nit_pa'=>'required|numeric|max:99999999',
            'fecha_nacimiento'=>'required',
            'direccion'=>'required',
            'telefono_pa'=>'required|numeric|max:99999999',
            'id_tipo_sangre'=>'required',
            'sexo'=>'required',
            'id_religion'=>'required',
            'id_responsable'=>'required',
            'imagen'=>'required|image|mimes:jpeg,png,svg|max:1024'
        ]);

        $Paciente=$request->all();

        if($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'img/';
            $imagenPaciente = date('YmdHis'). "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenPaciente);
            $Paciente['imagen'] = "$imagenPaciente";             
        }
        
        DB::table('paciente')->insert([
            'nombre_pa_1'=>$request->input('nombre_pa_1'),
            'nombre_pa_2'=>$request->input('nombre_pa_2'),
            'apellido_pa_1'=>$request->input('apellido_pa_1'),
            'apellido_ma_2'=>$request->input('apellido_ma_2'),
            'dpi_pa'=>$request->input('dpi_pa'),
            'nit_pa'=>$request->input('nit_pa'),
            'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
            'direccion'=>$request->input('direccion'),
            'telefono_pa'=>$request->input('telefono_pa'),
            'id_tipo_sangre'=>$request->input('id_tipo_sangre'),
            'sexo'=>$request->input('sexo'),
            'id_religion'=>$request->input('id_religion'),
            'id_responsable'=>$request->input('id_responsable'),
            'fecha_ingreso'=>DB::raw('now()'),
            'fecha_modificacion'=>DB::raw('now()'),
            'fecha_retiro'=>NULL,
            'foto_paciente'=>$Paciente['imagen'],
            'estado'=>'Activo'
        ]);
        
        return redirect()->route('pacientes.index');
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
    public function edit(Paciente $paciente)
    {
        //
        $religiones=Religion::paginate(5);
        $sangres=TipoSangre::paginate(5);
        $responsables=Responsable::paginate(5);
        return view('pacientes.editar',compact('paciente','religiones','sangres','responsables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paciente $paciente)
    {
        //
        $this->validate($request, [
            'nombre_pa_1'=>'required',
            'nombre_pa_1'=>'required',
            'apellido_pa_1'=>'required',
            'apellido_ma_2'=>'required',
            'dpi_pa'=>'required|numeric|max:99999999999999',
            'nit_pa'=>'required|numeric|max:99999999',
            'fecha_nacimiento'=>'',
            'direccion'=>'required',
            'telefono_pa'=>'required|numeric|max:99999999',
            'id_tipo_sangre'=>'',
            'sexo'=>'',
            'id_religion'=>'',
            'id_responsable'=>'',
            'imagen'=>'image|mimes:jpeg,png,svg|max:1024'
        ]);

        $pas=$request->all();

        if($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'img/';
            $imagenPaciente = date('YmdHis'). "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenPaciente);
            $pas['imagen'] = "$imagenPaciente";             
        }else{
            unset($pas['imagen']);
            $pas['imagen']="";
        }

        $valSangre =$request->input('id_tipo_sangre');
        $valSexo =$request->input('sexo');
        $valReligion =$request->input('id_religion');
        $valResponsable =$request->input('id_responsable');

        if($valSangre=="" && $valSexo=="" && $valReligion=="" && $valResponsable=="" && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if ($valSangre>0 && $valSexo=="" && $valReligion=="" && $valResponsable=="" && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_tipo_sangre'=>$request->input('id_tipo_sangre'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre>0 && $valSexo>0 && $valReligion=="" && $valResponsable=="" && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_tipo_sangre'=>$request->input('id_tipo_sangre'),
                'sexo'=>$request->input('sexo'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre>0 && $valSexo>0 && $valReligion>0 && $valResponsable=="" && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_tipo_sangre'=>$request->input('id_tipo_sangre'),
                'sexo'=>$request->input('sexo'),
                'id_religion'=>$request->input('id_religion'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        } 
        else if($valSangre>0 && $valSexo>0 && $valReligion>0 && $valResponsable>0 && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_tipo_sangre'=>$request->input('id_tipo_sangre'),
                'sexo'=>$request->input('sexo'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre>0 && $valSexo>0 && $valReligion>0 && $valResponsable>0 && $pas['imagen']>0 && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_tipo_sangre'=>$request->input('id_tipo_sangre'),
                'sexo'=>$request->input('sexo'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre>0 && $valSexo>0 && $valReligion>0 && $valResponsable>0 && $pas['imagen']>0 && $pas['fecha_nacimiento']>0){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_tipo_sangre'=>$request->input('id_tipo_sangre'),
                'sexo'=>$request->input('sexo'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo>0 && $valReligion=="" && $valResponsable=="" && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'sexo'=>$request->input('sexo'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre=="" && $valSexo>0 && $valReligion>0 && $valResponsable=="" && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'sexo'=>$request->input('sexo'),
                'id_religion'=>$request->input('id_religion'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre=="" && $valSexo>0 && $valReligion>0 && $valResponsable>0 && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'sexo'=>$request->input('sexo'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre=="" && $valSexo>0 && $valReligion>0 && $valResponsable>0 && $pas['imagen']>0 && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'sexo'=>$request->input('sexo'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo>0 && $valReligion>0 && $valResponsable>0 && $pas['imagen']>0 && $pas['fecha_nacimiento']>0){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'sexo'=>$request->input('sexo'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion>0 && $valResponsable=="" && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_religion'=>$request->input('id_religion'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion>0 && $valResponsable>0 && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion>0 && $valResponsable>0 && $pas['imagen']>0 && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion>0 && $valResponsable>0 && $pas['imagen']>0 && $pas['fecha_nacimiento']>0){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_religion'=>$request->input('id_religion'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion=="" && $valResponsable>0 && $pas['imagen']=="" && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion=="" && $valResponsable>0 && $pas['imagen']>0 && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion=="" && $valResponsable>0 && $pas['imagen']>0 && $pas['fecha_nacimiento']>0){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'id_responsable'=>$request->input('id_responsable'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion=="" && $valResponsable=="" && $pas['imagen']>0 && $pas['fecha_nacimiento']==""){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion=="" && $valResponsable=="" && $pas['imagen']>0 && $pas['fecha_nacimiento']>0){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'fecha_modificacion'=>DB::raw('now()'),
                'foto_paciente'=>$pas['imagen']
            ]);
        }
        else if($valSangre=="" && $valSexo=="" && $valReligion=="" && $valResponsable=="" && $pas['imagen']=="" && $pas['fecha_nacimiento']>0){
            DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
                'nombre_pa_1'=>$request->input('nombre_pa_1'),
                'nombre_pa_2'=>$request->input('nombre_pa_2'),
                'apellido_pa_1'=>$request->input('apellido_pa_1'),
                'apellido_ma_2'=>$request->input('apellido_ma_2'),
                'dpi_pa'=>$request->input('dpi_pa'),
                'nit_pa'=>$request->input('nit_pa'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_pa'=>$request->input('telefono_pa'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }

        return redirect()->route('pacientes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paciente $paciente)
    {
        //
        DB::table('paciente')->where('id_paciente', $paciente['id_paciente'])->update([
            'fecha_retiro'=>DB::raw('now()'),
            'estado'=>'Desactivado'
        ]);
        return redirect()->route('pacientes.index');
    }
}
