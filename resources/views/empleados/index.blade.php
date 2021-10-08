@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Empleados</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                
            
                        @can('crear-empleado')
                        <a class="btn btn-warning" href="{{ route('empleados.create') }}">Nuevo</a>
                        @endcan

                        <div class="table-responsive">
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Nombre</th>
                                    <th style="color:#fff;">DPI</th> 
                                    <th style="color:#fff;">Dirección</th> 
                                    <th style="color:#fff;">Teléfonos</th> 
                                    <th style="color:#fff;">Fecha de Ingreso</th> 
                                    <th style="color:#fff;">Puesto</th>
                                    <th style="color:#fff;">Sueldo</th> 
                                    <th style="color:#fff;">Acciones</th>                                                                                                   
                              </thead>
                              <tbody>
                            @foreach ($empleados as $empleado)
                            <tr>
                                <td style="display: none;">{{ $empleado->id_empleado }}</td>                                
                                <td>{{ $empleado->nombre }}</td>
                                <td>{{ $empleado->dpi_emp }}</td>
                                <td>{{ $empleado->direccion }}</td>
                                <td>{{ $empleado->telefonos }}</td>
                                <td>{{ $empleado->fecha_ingreso }}</td>
                                <td>{{ $empleado->puesto }}</td>
                                <td>{{ $empleado->sueldo }}</td>
                                <td>
                                    <form action="{{ route('empleados.destroy',$empleado->id_empleado) }}" method="POST">                                        
                                        @can('editar-empleado')
                                        <a class="btn btn-info" href="{{ route('empleados.edit',$empleado->id_empleado) }}">Editar</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-empleado')
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                        <!-- Ubicamos la paginacion a la derecha -->
                        <div class="pagination justify-content-end">
                            {!! $empleados->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection