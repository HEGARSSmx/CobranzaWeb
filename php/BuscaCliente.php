<?php
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Busqueda de Cliente</h1>
        </div>
        <div class="modal-body" >
            <table class="table table-responsive table-striped" id="tblClientes">
                <thead>
                    <tr>
                        <th>Id cliente</th>
                        <th>R.F.C.</th>
                        <th>Nombre</th>
                        <th>A. Paterno</th>
                        <th>A. Materno</th>
                        <th>Direcci&oacute;n</th>
                    </tr>
                </thead>
            </table>
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="returnIdCliente()"><span class="glyphicon glyphicon-ok"></span> Seleccionar</button>
        </div>
    </div>
    <script>
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
                    {"data": "direccion"}
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
            $("#MyModal").on("hidden.bs.modal", function () {
                DatosClienteText();
            });
        });

        function returnIdCliente() {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblClientes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                $("#inputIdCliente").val("0");
            } else {
                $("#inputIdCliente").val(aData[0].idCliente);
            }
        }
    </script>
</div>