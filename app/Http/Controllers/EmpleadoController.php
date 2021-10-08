<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empleado;
use App\Models\Puesto;

class EmpleadoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-empleado|crear-empleado|editar-empleado|borrar-empleado', ['only'=>['index']]);
        $this->middleware('permission:crear-empleado', ['only'=>['create','store']]);
        $this->middleware('permission:editar-empleado|editar-puesto', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-empleado', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$empleados=Empleado::paginate(5); aqui aplicamos paginacion modo simple
        $empleados=DB::table('vistaempleado')->where('estado','Activo')->select('*')->paginate(5);
        return view('empleados.index', compact('empleados')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $puestos=Puesto::paginate(5);
        return view('empleados.crear',compact('puestos'));
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
            'nombre_emp_1'=>'required',
            'nombre_emp_2'=>'required',
            'apellido_emp_1'=>'required',
            'apellido_emp_2'=>'required',
            'dpi_emp'=>'required|numeric|max:99999999999999',
            'nit_emp'=>'required|numeric|max:99999999',
            'fecha_nacimiento'=>'required',
            'direccion'=>'required',
            'telefono_emp'=>'required|numeric|max:99999999',
            'telefono_emp2'=>'required|numeric|max:99999999',
            'imagen'=>'required|image|mimes:jpeg,png,svg|max:1024',
            'id_puesto'=>'required'
        ]);

        $Empleado=$request->all();

        if($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'img/';
            $imagenEmpleado = date('YmdHis'). "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenEmpleado);
            $Empleado['imagen'] = "$imagenEmpleado";             
        }
        
        DB::table('personal_administrativo')->insert([
            'nombre_emp_1'=>$request->input('nombre_emp_1'),
            'nombre_emp_2'=>$request->input('nombre_emp_2'),
            'apellido_emp_1'=>$request->input('apellido_emp_1'),
            'apellido_emp_2'=>$request->input('apellido_emp_2'),
            'dpi_emp'=>$request->input('dpi_emp'),
            'nit_emp'=>$request->input('nit_emp'),
            'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
            'direccion'=>$request->input('direccion'),
            'telefono_emp'=>$request->input('telefono_emp'),
            'telefono_emp2'=>$request->input('telefono_emp2'),
            'foto_emp'=>$Empleado['imagen'],
            'fecha_ingreso'=>DB::raw('now()'),
            'fecha_modificacion'=>DB::raw('now()'),
            'fecha_retiro'=>NULL,
            'estado'=>'Activo',
            'id_puesto'=>$request->input('id_puesto')
        ]);
        
        return redirect()->route('empleados.index');

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
    public function edit(Empleado $empleado)
    {
        //
        $puestos=Puesto::paginate(5);
        return view('empleados.editar', compact('empleado','puestos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        //
        $this->validate($request, [
            'nombre_emp_1'=>'required',
            'nombre_emp_2'=>'required',
            'apellido_emp_1'=>'required',
            'apellido_emp_2'=>'required',
            'dpi_emp'=>'required',
            'nit_emp'=>'required',
            'fecha_nacimiento'=>'',
            'direccion'=>'required',
            'telefono_emp'=>'required|numeric|max:99999999',
            'telefono_emp2'=>'required|numeric|max:99999999',
            'imagen'=>'image|mimes:jpeg,png,svg|max:1024',
            'id_puesto'=>''
        ]);

        $empl=$request->all();

        if($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'img/';
            $imagenEmpleado = date('YmdHis'). "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenEmpleado);
            $empl['imagen'] = "$imagenEmpleado";             
        }else{
            unset($empl['imagen']);
            $empl['imagen']="";
        }

        $valPuesto =$request->input('id_puesto');
        $valNacimiento = $request->input('fecha_nacimiento');

        
       /* if($valPuesto=="" && $empl['imagen']=="" && $valNacimiento==""){
            print_r("no hay puesto ");
            echo '<br/>';
            print_r("no hay imagen ");
            echo '<br/>';
            print_r("no hay fecha ");
        }
        else if ($valPuesto>0 && $empl['imagen']=="" && $valNacimiento==""){
            print_r($valPuesto);
            echo '<br/>';
            print_r("no hay imagen ");
            echo '<br/>';
            print_r("no hay fecha ");
        }
        else if ($valPuesto>0 && $empl['imagen']>0 && $valNacimiento==""){
            print_r($valPuesto);
            echo '<br/>';
            print_r($empl['imagen']);
            echo '<br/>';
            print_r("no hay fecha ");
        }
        else if ($valPuesto>0 && $empl['imagen']>0 && $valNacimiento>0){
            print_r($valPuesto);
            echo '<br/>';
            print_r($empl['imagen']);
            echo '<br/>';
            print_r($valNacimiento);
        }*/

        /*ver el id del empleado dentro del array
        print_r($empleado['id_empleado']);*/

        /*si hay fecha de nacimiento para cambiar
        if($valNacimiento==""){
            print_r("no hay fecha");
        }
        else if ($empl['fecha_nacimiento']>0){
            print_r($valNacimiento);
        }*/
        

        /*si hay imagen para cambiar
        if($empl['imagen']==null){
            print_r("no hay imagen");
        }
        else if($empl['imagen']>0){
            print_r("hay imagen");
        }*/
        
        
       if($valPuesto=="" && $empl['imagen']=="" && $valNacimiento==""){
            DB::table('personal_administrativo')->where('id_empleado', $empleado['id_empleado'])->update([
                'nombre_emp_1'=>$request->input('nombre_emp_1'),
                'nombre_emp_2'=>$request->input('nombre_emp_2'),
                'apellido_emp_1'=>$request->input('apellido_emp_1'),
                'apellido_emp_2'=>$request->input('apellido_emp_2'),
                'dpi_emp'=>$request->input('dpi_emp'),
                'nit_emp'=>$request->input('nit_emp'),
                'direccion'=>$request->input('direccion'),
                'telefono_emp'=>$request->input('telefono_emp'),
                'telefono_emp2'=>$request->input('telefono_emp2'),
                'fecha_modificacion'=>DB::raw('now()')
            ]);
        }
        else if($valPuesto>0 && $empl['imagen']=="" && $valNacimiento=="") {
            DB::table('personal_administrativo')->where('id_empleado', $empleado['id_empleado'])->update([
                'nombre_emp_1'=>$request->input('nombre_emp_1'),
                'nombre_emp_2'=>$request->input('nombre_emp_2'),
                'apellido_emp_1'=>$request->input('apellido_emp_1'),
                'apellido_emp_2'=>$request->input('apellido_emp_2'),
                'dpi_emp'=>$request->input('dpi_emp'),
                'nit_emp'=>$request->input('nit_emp'),
                'direccion'=>$request->input('direccion'),
                'telefono_emp'=>$request->input('telefono_emp'),
                'telefono_emp2'=>$request->input('telefono_emp2'),
                'fecha_modificacion'=>DB::raw('now()'),
                'id_puesto'=>$request->input('id_puesto')
            ]);
        }
        else if($valPuesto>0 && $empl['imagen']>0 && $valNacimiento==""){
            DB::table('personal_administrativo')->where('id_empleado', $empleado['id_empleado'])->update([
                'nombre_emp_1'=>$request->input('nombre_emp_1'),
                'nombre_emp_2'=>$request->input('nombre_emp_2'),
                'apellido_emp_1'=>$request->input('apellido_emp_1'),
                'apellido_emp_2'=>$request->input('apellido_emp_2'),
                'dpi_emp'=>$request->input('dpi_emp'),
                'nit_emp'=>$request->input('nit_emp'),
                'direccion'=>$request->input('direccion'),
                'telefono_emp'=>$request->input('telefono_emp'),
                'telefono_emp2'=>$request->input('telefono_emp2'),
                'foto_emp'=>$empl['imagen'],
                'fecha_modificacion'=>DB::raw('now()'),
                'id_puesto'=>$request->input('id_puesto')
            ]);
        }
        else if($valPuesto>0 && $empl['imagen']>0 && $valNacimiento>0){
            DB::table('personal_administrativo')->where('id_empleado', $empleado['id_empleado'])->update([
                'nombre_emp_1'=>$request->input('nombre_emp_1'),
                'nombre_emp_2'=>$request->input('nombre_emp_2'),
                'apellido_emp_1'=>$request->input('apellido_emp_1'),
                'apellido_emp_2'=>$request->input('apellido_emp_2'),
                'dpi_emp'=>$request->input('dpi_emp'),
                'nit_emp'=>$request->input('nit_emp'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_emp'=>$request->input('telefono_emp'),
                'telefono_emp2'=>$request->input('telefono_emp2'),
                'foto_emp'=>$empl['imagen'],
                'fecha_modificacion'=>DB::raw('now()'),
                'id_puesto'=>$request->input('id_puesto')
            ]);
        }
        else if($valPuesto=="" && $empl['imagen']>0 && $valNacimiento>0){
            DB::table('personal_administrativo')->where('id_empleado', $empleado['id_empleado'])->update([
                'nombre_emp_1'=>$request->input('nombre_emp_1'),
                'nombre_emp_2'=>$request->input('nombre_emp_2'),
                'apellido_emp_1'=>$request->input('apellido_emp_1'),
                'apellido_emp_2'=>$request->input('apellido_emp_2'),
                'dpi_emp'=>$request->input('dpi_emp'),
                'nit_emp'=>$request->input('nit_emp'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_emp'=>$request->input('telefono_emp'),
                'telefono_emp2'=>$request->input('telefono_emp2'),
                'foto_emp'=>$empl['imagen'],
                'fecha_modificacion'=>DB::raw('now()'),
            ]);
        }
        else if($valPuesto=="" && $empl['imagen']=="" && $valNacimiento>0){
            DB::table('personal_administrativo')->where('id_empleado', $empleado['id_empleado'])->update([
                'nombre_emp_1'=>$request->input('nombre_emp_1'),
                'nombre_emp_2'=>$request->input('nombre_emp_2'),
                'apellido_emp_1'=>$request->input('apellido_emp_1'),
                'apellido_emp_2'=>$request->input('apellido_emp_2'),
                'dpi_emp'=>$request->input('dpi_emp'),
                'nit_emp'=>$request->input('nit_emp'),
                'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
                'direccion'=>$request->input('direccion'),
                'telefono_emp'=>$request->input('telefono_emp'),
                'telefono_emp2'=>$request->input('telefono_emp2'),
                'fecha_modificacion'=>DB::raw('now()'),
            ]);
        }
        else if($valPuesto=="" && $empl['imagen']>0 && $valNacimiento==""){
            DB::table('personal_administrativo')->where('id_empleado', $empleado['id_empleado'])->update([
                'nombre_emp_1'=>$request->input('nombre_emp_1'),
                'nombre_emp_2'=>$request->input('nombre_emp_2'),
                'apellido_emp_1'=>$request->input('apellido_emp_1'),
                'apellido_emp_2'=>$request->input('apellido_emp_2'),
                'dpi_emp'=>$request->input('dpi_emp'),
                'nit_emp'=>$request->input('nit_emp'),
                'direccion'=>$request->input('direccion'),
                'telefono_emp'=>$request->input('telefono_emp'),
                'telefono_emp2'=>$request->input('telefono_emp2'),
                'foto_emp'=>$empl['imagen'],
                'fecha_modificacion'=>DB::raw('now()'),
            ]);
        }

        return redirect()->route('empleados.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        //
        DB::table('personal_administrativo')->where('id_empleado', $empleado['id_empleado'])->update([
            'fecha_retiro'=>DB::raw('now()'),
            'estado'=>'Desactivado'
        ]);
        return redirect()->route('empleados.index');
    }
}
