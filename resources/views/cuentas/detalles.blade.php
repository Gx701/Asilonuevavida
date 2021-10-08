@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Detalles de Cuenta</h3>
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
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Tipo de Movimiento</th>
                                    <th style="color:#fff;">Descripción</th> 
                                    <th style="color:#fff;">Saldo</th> 
                                    <th style="color:#fff;">Fecha de Movimiento</th> 
                                    <th style="color:#fff;">Fecha de Pago</th> 
                                    <th style="color:#fff;">Estado</th> 
                                    <th style="color:#fff;">Acciones</th>                                                                                                   
                              </thead>
                              <tbody>
                            @foreach ($cuentasdetalles as $detalle)
                            <tr>
                                <td style="display: none;">{{ $detalle->id_movimiento_cuenta }}</td>    
                                <td style="display: none;">{{ $detalle->id_cuenta }}</td>                            
                                <td>{{ $detalle->tipo_movimiento }}</td>
                                <td>{{ $detalle->descripcion}}</td>
                                <td>{{ $detalle->monto }}</td>
                                <td>{{ $detalle->fecha_movimiento }}</td>
                                <td>{{ $detalle->fecha_pago }}</td>
                                <td>{{ $detalle->estado }}</td>
                                <td>
                                    <form action="{{ route('cuentas.update',$detalle->id_cuenta) }}" method="POST">                                        
                                       
                                        @if ($detalle->estado=='Pendiente')
                                        @can('editar-cuenta')
                                        <a class="btn btn-info" href="{{ route('cuentas.edit',$detalle->id_cuenta) }}">Pagar</a>
                                        @endcan
                                        @endif
                                        
                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-cuenta')
                                        <button type="submit" class="btn btn-danger">Eliminar Cuenta</button>
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
                            {!! $cuentasdetalles->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection