<?php
session_start();
if (!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])) {
    header("Location: /Cobranza/index.php");
    exit();
}

$idCliente = filter_input(INPUT_GET, 'id');
$nombre = filter_input(INPUT_GET, 'Nombre');

include './dataBaseClass/connection.php';
$cDb = new DataBase();
$result = $cDb->query("SELECT * FROM ExpedienteElectronico WHERE idCliente = $idCliente");
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button
            <h1 class="modal-title">Agregar Expediente al Cliente: <?php echo $nombre; ?></h1>
        </div>
        <div class="modal-body" style="margin: 20px;">
            <table id="tblExpedientes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($result)){?>
                    <tr>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['nombre'];?></td>
                        <td><a class="btn btn-success" href="/Cobranza/php/ShowFile.php?id=<?php echo $row['id'];?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <form action="" id="uploadForm" name="uploadForm" method="POST" enctype="multipart/form-data">
                <label class="control-label" for="inputId">Archivo:</label>
                <input type="text" id="txtTipoArchivo" name="tipoArchivo" value="1" hidden/>
                <input type="text" id="txtIdCliente" name="idCliente" value="<?php echo $idCliente;?>" hidden/>
                <input type="file" id="userfile" name="userfile" class="form-control input-sm" required />
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnUpload" onclick="cargar()">Cargar</button>
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