<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//spatie
use Spatie\Permission\Models\Permission;

class seederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permisos=[
           //Tabla roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
            //tabla blogs
            'ver-blog',
            'crear-blog',
            'editar-blog',
            'borrar-blog',
            //tabla-usuarios
            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'borrar-usuario'
        ];
        foreach($permisos as $permiso){
            Permission::create(['name'=>$permiso]);
        }
    }
}
