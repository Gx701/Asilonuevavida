@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Habitaciones</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                
            
                        @can('crear-habitacion')
                        <a class="btn btn-warning" href="{{ route('habitaciones.create') }}">Nuevo</a>
                        @endcan

                        <div class="table-responsive">
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">No. Habitación</th>
                                    <th style="color:#fff;">Ubicacion</th> 
                                    <th style="color:#fff;">Estado</th> 
                                    <th style="color:#fff;">Precio Mensual</th> 
                                    <th style="color:#fff;">Acciones</th>                                                                                                   
                              </thead>
                              <tbody>
                            @foreach ($habitaciones as $habitacion)
                            <tr>
                                <td style="display: none;">{{ $habitacion->id_habitacion }}</td>                                
                                <td>{{ $habitacion->num_habi }}</td>
                                <td>{{ $habitacion->ubicacion }}</td>
                                <td>{{ $habitacion->estado }}</td>
                                <td>{{ $habitacion->Precio_estadia_mensual }}</td>
                                <td>
                                    <form action="{{ route('habitaciones.destroy',$habitacion->id_habitacion) }}" method="POST">                                        
                                        @can('editar-habitacion')
                                        <a class="btn btn-info" href="{{ route('habitaciones.edit',$habitacion->id_habitacion) }}">Editar</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-habitacion')
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
                            {!! $habitaciones->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection