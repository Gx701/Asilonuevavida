@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Pacientes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                
            
                        @can('crear-paciente')
                        <a class="btn btn-warning" href="{{ route('pacientes.create') }}">Nuevo</a>
                        @endcan
            
                        <div class="table-responsive">
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Nombre</th>
                                    <th style="color:#fff;">DPI</th> 
                                    <th style="color:#fff;">Teléfono</th> 
                                    <th style="color:#fff;">Encargado</th> 
                                    <th style="color:#fff;">Teléfonos</th> 
                                    <th style="color:#fff;">Foto del Paciente</th> 
                                    <th style="color:#fff;">Parentesco con el paciente</th>
                                    <th style="color:#fff;">Acciones</th>                                                                                                   
                              </thead>
                              <tbody>
                            @foreach ($pacientes as $paciente)
                            <tr>
                                <td style="display: none;">{{ $paciente->id_paciente }}</td>                                
                                <td>{{ $paciente->nombre }}</td>
                                <td>{{ $paciente->dpi_pa }}</td>
                                <td>{{ $paciente->telefono_pa }}</td>
                                <td>{{ $paciente->encargado }}</td>
                                <td>{{ $paciente->telefonos }}</td>
                                <td>
                                    <img src="/img/{{ $paciente->foto_paciente }}" width="60%">
                                </td>
                                <td>{{ $paciente->parentesco }}</td>
                                <td>
                                    <form action="{{ route('pacientes.destroy',$paciente->id_paciente) }}" method="POST">                                        
                                        @can('editar-paciente')
                                        <a class="btn btn-info" href="{{ route('pacientes.edit',$paciente->id_paciente) }}">Editar</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-paciente')
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
                            {!! $pacientes->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection