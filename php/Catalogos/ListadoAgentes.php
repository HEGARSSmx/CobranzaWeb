<?php
include '../Header.php';
?>
<div class="main">
    <h1 class="page-header">Listado De Agentes</h1>
    <button class="btn btn-primary" id="btnAgregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
    <button class="btn btn-primary" id="btnEditar"><span class="glyphicon glyphicon-edit" ></span> Editar</button>
    <button class="btn btn-danger" id="btnEliminar"><span class="glyphicon glyphicon-remove"></span> Borrar</button>
    <br>
    <br>
    <table id="tblAgentes" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id agente</th>
                <th>Nombre</th>
                <th>Clave</th>
            </tr>
        </thead>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#tblAgentes').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/Cobranza/php/Catalogos/TablaAgentes.php",
            "columns": [
                {"data": "idAgente"},
                {"data": "nombre"},
                {"data": "clave"}
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
            MuestraModal.mostrar("/Cobranza/php/Catalogos/EditarAgente.php");
        });

        $("#btnEditar").click(function () {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblAgentes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                muestraMensaje("No se ha seleccionado un registro", "warning");
            } else {
                MuestraModal.mostrar("/Cobranza/php/Catalogos/EditarAgente.php?idAgente=" + aData[0].idAgente);
            }
        });

        $("#btnEliminar").click(function () {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblAgentes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                muestraMensaje("No se ha seleccionado un registro", "warning");
            } else {
                if (confirm("Desea eliminar el agente?"))
                {
                    app.showProcess();
                    $.ajax({
                        type: 'POST',
                        url: '/Cobranza/php/Catalogos/EliminarAgente.php',
                        data: "idAgente=" + aData[0].idAgente,
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