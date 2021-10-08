@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Responsables</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                
            
                        @can('crear-responsable')
                        <a class="btn btn-warning" href="{{ route('responsables.create') }}">Nuevo</a>
                        @endcan
            
                        <div class="table-responsive">
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Nombre</th>
                                    <th style="color:#fff;">DPI</th> 
                                    <th style="color:#fff;">Dirección</th> 
                                    <th style="color:#fff;">Teléfonos</th> 
                                    <th style="color:#fff;">Foto</th> 
                                    <th style="color:#fff;">Parentesco con el paciente</th>
                                    <th style="color:#fff;">Acciones</th>                                                                                                   
                              </thead>
                              <tbody>
                            @foreach ($responsables as $responsable)
                            <tr>
                                <td style="display: none;">{{ $responsable->id_responsable }}</td>                                
                                <td>{{ $responsable->nombre }}</td>
                                <td>{{ $responsable->dpi_res }}</td>
                                <td>{{ $responsable->direccion }}</td>
                                <td>{{ $responsable->telefonos }}</td>
                                <td>
                                    <img src="/img/{{ $responsable->foto_responsable }}" width="60%">
                                </td>
                                <td>{{ $responsable->parentesco }}</td>
                                <td>
                                    <form action="{{ route('responsables.destroy',$responsable->id_responsable) }}" method="POST">                                        
                                        @can('editar-responsable')
                                        <a class="btn btn-info" href="{{ route('responsables.edit',$responsable->id_responsable) }}">Editar</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-responsable')
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
                            {!! $responsables->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection