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
                
                            @if(Session::has('flash_message'))
                            <div class="alert alert-success">
                              <span class="glyphicon glyphicon-ok"></span>
                              <em> {!! session('flash_message') !!}</em>
                            </div>
                            @endif
            
                        @can('crear-horario')
                        <a class="btn btn-warning" href="{{ route('horarios.create') }}">Nuevo</a>
                        @endcan
            
                        <div class="table-responsive">
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Dia</th>
                                    <th style="color:#fff;">Hora de Inicio en la Mañana</th>
                                    <th style="color:#fff;">Hora de Salida en la Mañana</th> 
                                    <th style="color:#fff;">Hora de Inicio en la Tarde</th>
                                    <th style="color:#fff;">Hora de Salida en la Tarde</th>
                                    <th style="color:#fff;">Acciones</th>                                                                                                   
                              </thead>
                              <tbody>
                            @foreach ($horarios as $horario)
                            <tr>
                                <td style="display: none;">{{ $horario->id_horario }}</td>   
                                <td>{{ $horario->dia }}</td>                             
                                <td>{{ $horario->hora_inicio_m }}</td>
                                <td>{{ $horario->hora_salida_m }}</td>
                                <td>{{ $horario->hora_inicio_t }}</td>
                                <td>{{ $horario->hora_salida_t }}</td>
                                <td>
                                    <form action="{{ route('horarios.destroy',$horario->id_horario) }}" method="POST">                                        
                                        @can('editar-horario')
                                        <a class="btn btn-info" href="{{ route('horarios.edit',$horario->id_horario) }}">Editar</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-horario')
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
                            {!! $horarios->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection