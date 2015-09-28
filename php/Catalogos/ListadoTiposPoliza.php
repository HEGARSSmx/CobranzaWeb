<?php
include '../Header.php';
?>
<div class="main">
    <h1 class="page-header">Listado De Tipos De P&oacute;lizas</h1>
    <button class="btn btn-primary" id="btnAgregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
    <button class="btn btn-primary" id="btnEditar"><span class="glyphicon glyphicon-edit"></span> Editar</button>
    <button class="btn btn-danger" id="btnEliminar"><span class="glyphicon glyphicon-remove"></span> Borrar</button>
    <br>
    <br>
    <table id="tblTipos" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripci&oacute;n</th>
            </tr>
        </thead>
    </table>
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#tblTipos').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/Cobranza/php/Catalogos/TablaTiposPoliza.php",
                "columns": [
                    {"data": "idTipo"},
                    {"data": "nombre"},
                    {"data": "descripcion"}
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
                MuestraModal.mostrar("/Cobranza/php/Catalogos/EditarTipoPoliza.php");
                table.ajax.reload(null, false);
            });

            $("#btnEditar").click(function () {
                var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblTipos");
                var aData = oTT.fnGetSelectedData();
                if (aData.length !== 1) {
                    muestraMensaje("No se ha seleccionado un registro","warning");
                } else {
                    MuestraModal.mostrar("/Cobranza/php/Catalogos/EditarTipoPoliza.php?idTipo=" + aData[0].idTipo);
                }
            });
            $("#btnEliminar").click(function () {
                var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblipos");
                var aData = oTT.fnGetSelectedData();
                if (aData.length !== 1) {
                    muestraMensaje("No se ha seleccionado un registro","warning");
                } else {
                    app.showProcess();
                }
            });
        });
        
        function verDependientes(){
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblClientes");
            var aData = oTT.fnGetSelectedData();
            if(aData.length !== 1){
                 $("#mensaje").html('<center><div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>No se ha seleccionado un registro</div></center>');
            } else {
                var nombre = encodeURI(aData[0].nombre + " " + aData[0].paterno + " " + aData[0].materno);
                MuestraModal.mostrar("/Cobranza/php/Dependientes.php?IdCliente="+aData[0].idCliente + "&Nombre="+nombre);
            }
        }
    </script>
</div>