<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("Location: /Cobranza/login.php");
}
$lEdit = FALSE;
$cEncabezado = ($lEdit ? "Agregando: " . "Paquete nuevo" : "Paquete nuevo");
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 class="modal-title"><?php echo $cEncabezado; ?></h5>
        </div>
        <div class="modal-body well"  style="margin: 20px;">
            <form action="GuardaPaquete.php" id="inputForm">
                <div class="row">
                    <div class= "col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputIdPaquete">Id paquete:</label>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input-sm" id="inputIdPaquete" name="idPaquete" placeholder="Id del paquete nuevo">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputTipoPoliza">Tipo de p&oacute;liza:</label>
                        </p>
                    </div>
                    <div class = "col-md-3">
                        <input type="text" class="form-control input-sm" id="inputTipoPoliza" name="tipoPoliza" placeholder="Tipo de poliza">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class ="col-md-2">
                        <p class="text-right">
                            <label class="control-label" for="inputCobertura">Cobertura:</label>
                        </p>
                    </div>
                    <div class=" col-md-5">
                        <input type="text" class="form-control input-sm" id="inputCobertura" name="cobertura" placeholder="Cobertura amparada">
                    </div>
                </div>
                <br>
            </form>
        </div>
        <div class="modal-footer">
            <div class="progress" id="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar" style=" width: 100%;">Guardando</div>
            </div>
            <span id="mensaje"></span> 
            <button type="button" class="btn btn-primary" data-dissmiss="modal" id="btnGuardar">Guardar</button>
        </div>
    </div>
    <script>
            $(document).ready(function () {             $("#progress").hide();
                $("#btnGuardar").click(function (e) {                 $("#progress").show();
                var postData = $("#inputForm").serialize();
                $.ajax({
                    type: 'POST',
                    url: "/Cobranza/php/Catalogos/GuardaPaquete.php",
                    data: postData,
                    cache: false,
                    dataType: 'json',
                        beforeSubmit: function () {                         $("#mensaje").html("");
                        $("#progress").show();
                    },
                        success: function (data) {                         $("#progress").hide();
                            if (data.correcto) {                             $("#MyModal").modal('hide');

                            } else {                             $("#mensaje").html("<span style='color:#cc0000'>Error:</span> " + data.mensaje);
                        }
                    },
                        error: function () {                         $("#progress").hide();
                        $("#mensaje").html("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ");
                    }
                });
            });
        });
  </script>
