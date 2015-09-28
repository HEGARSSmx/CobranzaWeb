<?php
$idCliente = filter_input(INPUT_GET, "IdCliente");
$sNombre = filter_input(INPUT_GET, "Nombre");
$cEncabezado = $sNombre;
include './dataBaseClass/connection.php';

$cDb = new DataBase();
$result = $cDb->select(array("nombre", "nacimiento", "sexo"), "Dependiente", "idCliente = $idCliente", "", "");
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button
            <h1 class="modal-title">Listado de Dependientes: <b><?php echo $cEncabezado; ?></b></h1>
        </div>
        <div class="modal-body" style="margin: 20px;">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Nacimiento</th>
                        <th>Sexo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($result)){ ?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['nacimiento']; ?></td>
                            <td><?php echo $row['sexo']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-log-out"></span> Cerrar</button>
        </div>
    </div>
</div>