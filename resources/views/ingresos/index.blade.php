@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ingresos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            
                            @if(Session::has('flash_message'))
                            <div class="alert alert-success">
                              <span class="glyphicon glyphicon-ok"></span>
                              <em> {!! session('flash_message') !!}</em>
                            </div>
                        @endif
                
            
                        @can('crear-ingreso')
                        <a class="btn btn-warning" href="{{ route('ingresos.create') }}">Nuevo</a>
                        @endcan

                        <div class="table-responsive">
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Paciente</th>
                                    <th style="color:#fff;">No. Habitacion</th> 
                                    <th style="color:#fff;">Ubicacion</th> 
                                    <th style="color:#fff;">Precio Mensual</th> 
                                    <th style="color:#fff;">Acciones</th>                                                                                                   
                              </thead>
                              <tbody>
                            @foreach ($ingresos as $ingreso)
                            <tr>
                                <td style="display: none;">{{ $ingreso->id_ingreso }}</td>                                
                                <td>{{ $ingreso->nombre }}</td>
                                <td>{{ $ingreso->num_habi }}</td>
                                <td>{{ $ingreso->ubicacion }}</td>
                                <td>{{ $ingreso->Total_Pagar }}</td>
                                <td>
                                    <form action="{{ route('ingresos.destroy',$ingreso->id_ingreso) }}" method="POST">                                        
                                        @can('editar-ingreso')
                                        <a class="btn btn-info" href="{{ route('ingresos.edit',$ingreso->id_ingreso) }}">Editar</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-ingreso')
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
                            {!! $ingresos->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection