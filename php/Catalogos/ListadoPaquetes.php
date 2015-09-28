<?php
// Inciamos el encabezado de la aplicacion para comprobar el inicio de sesion
include '../Header.php';
?>
<div class="main">
    <h1 class="page-header">Listado De Paquetes</h1>
    <form action="#" method="LINK">
      <button type="submit" formaction="GuardaPaqueteNuevo.php" class="btn btn-primary" id="btnAgregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
      <button class="btn btn-primary" id="btnEditar"><span class="glyphicon glyphicon-edit" ></span> Editar</button>
      <button class="btn btn-danger" id="btnEliminar"><span class="glyphicon glyphicon-remove"></span> Borrar</button>
    </form>
    <br>
    <br>
    <table id="tblPaquetes" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id paquete</th>
                <th>Tipo de p&oacute;liza</th>
                <th>Cobertura</th>
            </tr>
        </thead>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#tblPaquetes').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/Cobranza/php/Catalogos/TablaPaquetes.php",
            "columns": [
                {"data": "idPaquete"},
                {"data": "tipoPoliza"},
                {"data": "cobertura"}
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "sDom": 'T<"clear">lfrtip',
            "oTableTools": {
                "sRowSelect": "single",
                "aButtons": ""
            }
        });

        $("#btnAgregar").click(function () {
            MuestraModal.mostrar("/Cobranza/php/Catalogos/GuardaPaqueteNuevo.php");
        });

        $("#btnEditar").click(function () {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblPaquetes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                muestraMensaje("No se ha seleccionado un registro", "warning");
            } else {
                var url = encodeURI("/Cobranza/php/Catalogos/EditarPaquete.php?idPaquete=" + aData[0].idPaquete + "&tipoPoliza=" + aData[0].tipoPoliza + "&cobertura=" + aData[0].cobertura);
                MuestraModal.mostrar(url);
            }
        });

        $("#btnEliminar").click(function () {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblPaquetes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                muestraMensaje("No se ha seleccionado un registro", "warning");
            } else {
                if (confirm("Desea eliminar el paquete?"))
                {
                    app.showProcess();
                    $.ajax({
                        type: 'POST',
                        url: '/Cobranza/php/Catalogos/EliminarPaquete.php',
                        data: "idPaquete=" + aData[0].idPaquete + "&tipoPoliza=" + aData[0].tipoPoliza + "&cobertura=" + aData[0].cobertura,
                        cache: false,
                        dataType: 'json',
                        success: function (data) {
                            if (data.eliminado) {
                                app.hideProcess();
                                muestraMensaje('Eliminado Correctamente', 'success');
                                table.ajax.reload(null, true);
                                app.hideProcess();
                            } else {
                                app.hideProcess();
                                muestraMensaje(data.mensaje, "error");
                            }
                        },
                        error: function () {
                            muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ", "error");
                        }
                    });
                }
            }
        });

        $("#MyModal").on("hidden.bs.modal", function () {
            table.ajax.reload(null, false);
        });

    });
</script>
