@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Cuentas de Pacientes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
            
                        <div class="table-responsive">
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Responsable de la Cuenta</th>
                                    <th style="color:#fff;">Paciente</th> 
                                    <th style="color:#fff;">Saldo</th> 
                                    <th style="color:#fff;">Fecha de Inicio</th> 
                                    <th style="color:#fff;">Fecha de Ultimo Movimiento</th> 
                                    <th style="color:#fff;">Acciones</th>                                                                                                   
                              </thead>
                              <tbody>
                            @foreach ($cuentas as $cuenta)
                            <tr>
                                <td style="display: none;">{{ $cuenta->id_cuenta }}</td>                                
                                <td>{{ $cuenta->responsable }}</td>
                                <td>{{ $cuenta->paciente}}</td>
                                <td>{{ $cuenta->saldo }}</td>
                                <td>{{ $cuenta->fecha_ingreso }}</td>
                                <td>{{ $cuenta->fecha_modificacion }}</td>
                                <td>
                                    <form action="{{ route('cuentas.destroy',$cuenta->id_cuenta) }}" method="POST">                                        
                                        @can('editar-cuenta')
                                        <a class="btn btn-info" href="{{ route('cuentas.show',$cuenta->id_cuenta) }}">Ver Detalles</a>
                                        @endcan
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                        <!-- Ubicamos la paginacion a la derecha -->
                        <div class="pagination justify-content-end">
                            {!! $cuentas->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection