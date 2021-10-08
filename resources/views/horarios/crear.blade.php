@extends('layouts.app')

<style>
    .file-upload {
  background-color: #ffffff;
  width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.file-upload-btn {
  width: 100%;
  margin: 0;
  color: #fff;
  background: #1FB264;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #15824B;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.file-upload-btn:hover {
  background: #1AA059;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.file-upload-btn:active {
  border: 0;
  transition: all .2s ease;
}

.file-upload-content {
  display: none;
  text-align: center;
}

.file-upload-input {
  position: absolute;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  outline: none;
  opacity: 0;
  cursor: pointer;
}

.image-upload-wrap {
  margin-top: 20px;
  border: 4px dashed #1FB264;
  position: relative;
}

.image-dropping,
.image-upload-wrap:hover {
  background-color: #1FB264;
  border: 4px dashed #ffffff;
}

.image-title-wrap {
  padding: 0 15px 15px 15px;
  color: #222;
}

.drag-text {
  text-align: center;
}

.drag-text h3 {
  font-weight: 100;
  text-transform: uppercase;
  color: #15824B;
  padding: 60px 0;
}

.file-upload-image {
  max-height: 200px;
  max-width: 200px;
  margin: auto;
  padding: 20px;
}

.remove-image {
  width: 200px;
  margin: 0;
  color: #fff;
  background: #cd4535;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #b02818;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.remove-image:hover {
  background: #c13b2a;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.remove-image:active {
  border: 0;
  transition: all .2s ease;
}
</style>

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Nuevo Ingreso</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">     
                                                                      
                        @if ($errors->any())                                                
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>                        
                                @foreach ($errors->all() as $error)                                    
                                    <span class="badge badge-danger">{{ $error }}</span>
                                @endforeach                        
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        @endif

                        <form action="{{ route('horarios.store') }}" method="POST" enctype="multipart/form-data">
                          @csrf  
  
                        <div class="row">

                          <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                               <label for="id_dia" class="form-control">Dia a Asignar</label>
                               <select name="id_dia" id="id_dia">
                                <option value="">---Seleccione el Dia</option>
                               @foreach ($dias as $dia)
                                   <option value="{{ $dia['id_dia'] }}">{{ $dia['dia'] }}</option>
                               @endforeach
                               </select>
                            </div>
                          </div>
                          
                         </div>    

                         <div class="row">  
                          <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="id_turno" class="form-control">Turno a Asignar</label>
                                <select name="id_turno" id="id_turno">
                                 <option value="">---Seleccione el Turno</option>
                                @foreach ($turnos as $turno)
                                    <option value="{{ $turno['id_turno'] }}">Entrada:{{$turno['hora_inicio_m']->toTimeString()}} Salida:{{$turno['hora_salida_m']->toTimeString()}} Entrada:{{$turno['hora_inicio_t']->toTimeString()}} Salida:{{$turno['hora_salida_t']->toTimeString()}}</option>
                                @endforeach
                                </select>
                            </div>
                           </div>
                        </div> 

                        <button onclick="agregar_elemento()" type="button" class="btn btn-success float-right">Agregar</button>  
                        
                        <table class="table">
                          <thead>
                              <tr>
                                  <th>Dia</th>
                                  <th>Turno</th>
                                  <th>Opciones</th>
                              </tr>
                          </thead>
                          <tbody id="tblHorario">
      
                          </tbody>
                      </table>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>

                    
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 
<script>

    function agregar_elemento() {
        let dia_id = $("#id_dia option:selected").val();
        let dia_text = $("#id_dia option:selected").text();
        let turno_id = $("#id_turno option:selected").val();
        let turno_text = $("#id_turno option:selected").text();

        var conteo=0;

        if (dia_id > 0 && turno_id>0) {

            $("#tblHorario").append(`
                    <tr id="tr-${conteo}">
                        <td>
                            <input type="hidden" name="dia_id[]" value="${dia_id}" />
                            ${dia_text}    
                        </td>
                        <td>
                            <input type="hidden" name="turno_id[]" value="${turno_id}" />
                            ${turno_text}    
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="eliminar_insumo(${conteo})">X</button>    
                        </td>
                    </tr>
                `);
                conteo++;
        } else {
            alert("Se debe ingresar un dia y horario valido");
        }
    }


    function eliminar_insumo(id) {
        $("#tr-" + id).remove();
    }

</script>
 
@endsection