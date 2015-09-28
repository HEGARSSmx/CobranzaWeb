<?php
include 'Header.php';
?>

<div class="main">
    <h1 class="page-header">Listado De Compa&ntilde;&iacute;as</h1>

    <button class="btn btn-primary" id="btnAgregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
    <button class="btn btn-primary" id="btnEditar"><span class="glyphicon glyphicon-edit"></span> Editar</button>
    <button class="btn btn-danger" id="btnEliminar"><span class="glyphicon glyphicon-remove"></span> Borrar</button>
    <br>
    <br>
    <table id="tblCompanias" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Direcci&oacute;n</th>
                <th>Tel&eacute;fono</th>
                <th>Portal</th>
            </tr>
        </thead>
    </table>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#tblCompanias").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/Cobranza/php/TablaCompanias.php",
                "columns": [
                    {
                        "data": "idCompania",
                        "visible": false
                    },
                    {"data": "nombre"},
                    {"data": "direccion"},
                    {"data": "telefono"},
                    {"data": "portal",
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href='" + oData.portal + "' target='_blank'>" + oData.portal + "</a>");
                        }
                    }
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
                MuestraModal.mostrar("/Cobranza/php/EditarCompania.php");
            });

            $("#btnEditar").click(function () {
                var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblCompanias");
                var aData = oTT.fnGetSelectedData();
                if (aData.length !== 1) {
                    muestraMensaje("No se ha seleccionado un registro","warning");
                } else {
                    MuestraModal.mostrar("/Cobranza/php/EditarCompania.php?idCompania=" + aData[0].idCompania);
                }
            });
            $("#btnEliminar").click(function () {
                var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblCompanias");
                var aData = oTT.fnGetSelectedData();
                if (aData.length !== 1) {
                    muestraMensaje("No se ha seleccionado un registro");
                } else {
                    app.showProcess();
                    table.ajax.reload(null, false);
                }
            });
        });
    </script>
</div>