<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button
            <h1 class="modal-title">Subir Documento</h1>
        </div>
        <div class="modal-body" style="margin: 20px;">
            <form action="" id="uploadForm" name="uploadForm" method="POST" enctype="multipart/form-data">
                <label class="control-label" for="inputId">Archivo:</label>
                <input type="file" id="userfile" name="userfile" class="form-control input-sm" required />
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnUpload" data-dissmiss="modal" onclick="cargar()">Cargar</button>
        </div>
    </div>
    <script>
        function cargar() {
            var fd = new FormData(document.getElementById("uploadForm"));
            
            $.ajax({
                url: "/Cobranza/php/Upload.php",
                type: "POST",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: fd,
                success: function (respuesta) {
                    if (respuesta.correcto) {
                        muestraMensaje(respuesta.mensaje, "success");
                        $("#MyModal").modal('hide');
                    } else {
                        muestraMensaje(respuesta.mensaje, "error");
                    }
                },
                error: function () {
                    muestraMensaje("Error al tratar de subir el archivo", "error");
                }
            });
        }
    </script>
</div>