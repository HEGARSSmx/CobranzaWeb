<?php
include './Header.php';
?>
<div class="main">
    <h1 class="page-header">Listado De Clientes</h1>
    <button class="btn btn-primary" id="btnAgregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
    <button class="btn btn-primary" id="btnEditar"><span class="glyphicon glyphicon-edit"></span> Editar</button>
    <button class="btn btn-danger" id="btnEliminar"><span class="glyphicon glyphicon-remove"></span> Borrar</button>
    <button class="btn btn-primary" id="btnDependientes" onclick="verDependientes()"><span class="glyphicon glyphicon-eye-open"></span> Dependientes</button>
    <button class="btn btn-primary" id="btnExpediente" onclick="verExpediente()"><span class="glyphicon glyphicon-book"> Expediente</span></button>
    <br>
    <br>
    <div id="mensaje"></div>
    <table id="tblClientes" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>R.F.C.</th>
                <th>Nombre</th>
                <th>A. Paterno</th>
                <th>A. Materno</th>
                <th>Direcci&oacute;n</th>
                <th>Tel&eacute;fono</th>
                <th>Colonia</th>
            </tr>
        </thead>
    </table>
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#tblClientes').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/Cobranza/php/TablaClientes.php",
                "columns": [
                    {
                        "data": "idCliente",
                        "visible": false
                    },
                    {"data": "rfc"},
                    {"data": "nombre"},
                    {"data": "paterno"},
                    {"data": "materno"},
                    {"data": "direccion"},
                    {"data": "telefono"},
                    {"data": "colonia"}
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
                MuestraModal.mostrar("/Cobranza/php/EditarCliente.php");
                table.ajax.reload(null, false);
            });

            $("#btnEditar").click(function () {
                var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblClientes");
                var aData = oTT.fnGetSelectedData();
                if (aData.length !== 1) {
                    muestraMensaje("No se ha seleccionado un registro", "warning");
                } else {
                    MuestraModal.mostrar("/Cobranza/php/EditarCliente.php?idCliente=" + aData[0].idCliente);
                }
            });
            $("#btnEliminar").click(function () {
                var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblClientes");
                var aData = oTT.fnGetSelectedData();
                if (aData.length !== 1) {
                    muestraMensaje("No se ha seleccionado un registro", "warning");
                } else {
                    if (confirm("Desea eliminar el cliente?"))
                    {
                        //app.showProcess();
                        $.ajax({
                            type: 'POST',
                            url: '/Cobranza/php/EliminarCliente.php',
                            data: "idCliente=" + aData[0].idCliente,
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
                                app.hideProcess();
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

        function verDependientes() {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblClientes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                muestraMensaje("No se ha seleccionado un registro", "warning");
            } else {
                var nombre = encodeURI(aData[0].nombre + " " + aData[0].paterno + " " + aData[0].materno);
                MuestraModal.mostrar("/Cobranza/php/Dependientes.php?IdCliente=" + aData[0].idCliente + "&Nombre=" + nombre);
            }
        }

        function verExpediente() {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblClientes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                muestraMensaje("No se ha seleccionado un registro", "warning");
            } else {
                var nombre = encodeURI(aData[0].nombre + " " + aData[0].paterno + " " + aData[0].materno);
                MuestraModal.mostrar("/Cobranza/php/ListadoExpedientes.php?id=" + aData[0].idCliente + "&Nombre=" + nombre);
            }
        }

    </script>
</div>
<?php 
include './Footer.php';