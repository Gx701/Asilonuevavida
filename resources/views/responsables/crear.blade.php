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
            <h3 class="page__heading">Nuevo Responsable</h3>
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

                    <form action="{{ route('responsables.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="nombre_res_1">Primer Nombre</label>
                                   <input type="text" name="nombre_res_1" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="nombre_res_2">Segundo Nombre</label>
                                   <input type="text" name="nombre_res_2" class="form-control">
                                </div>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="apellido_res_1">Primer Apellido</label>
                                   <input type="text" name="apellido_res_1" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="apellido_res_2">Segundo Apellido</label>
                                   <input type="text" name="apellido_res_2" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="dpi_res">DPI</label>
                                   <input type="text" name="dpi_res" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="nit_res">NIT</label>
                                   <input type="text" name="nit_res" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                   <input type="date" name="fecha_nacimiento" class="form-control">     
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="direccion">Dirección</label>
                                   <input type="text" name="direccion" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="telefono_res">Teléfono</label>
                                   <input type="text" name="telefono_res" class="form-control">
                                </div>
                            </div> 
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="telefono_res2">Teléfono de Respaldo</label>
                                   <input type="text" name="telefono_res2" class="form-control">
                                </div>
                            </div> 
                            
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="id_parentesco" class="form-control">Parentesco con el Paciente</label>
                                   <select name="id_parentesco" id="id_parentesco">
                                   @foreach ($parentescos as $parentesco)
                                       <option value="{{ $parentesco['id_parentesco'] }}">{{ $parentesco['parentesco'] }}</option>
                                   @endforeach
                                   </select>
                                </div>
                            </div>

                            <div class="file-upload">
                                <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Añadir imagen</button>
                              
                                <div class="image-upload-wrap">
                                  <input class="file-upload-input" name="imagen" type='file' onchange="readURL(this);" accept="image/*" />
                                  <div class="drag-text">
                                    <h3>Drag and drop a file or select add Image</h3>
                                  </div>
                                </div>
                                <div class="file-upload-content">
                                  <img class="file-upload-image" src="#" alt="your image" />
                                  <div class="image-title-wrap">
                                    <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                  </div>
                                </div>
                              </div>   
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
        function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
  });
  $('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});
    </script>
@endsection