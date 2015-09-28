<?php ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Buscar Orden De Trabajo</h1>
        </div>
        <div class="modal-body" >
            <table class="table table-responsive table-striped" id="tblInfOrdenTrabajo" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Id orden</th>
                        <th>Id compa&ntilde;&iacute;a</th>
                        <th>Compa&ntilde;&iacute;a</th>
                        <th>Movimiento solcitado</th>
                        <th>Id cliente</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
            </table>     
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="returnIdOrden()"><span class="glyphicon glyphicon-ok"></span> Seleccionar</button>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var table = $('#tblInfOrdenTrabajo').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/Cobranza/php/TablaOrdenTrabajo.php",
                "columns": [
                    {"data": "idOrden"},
                    {"data": "idCompania"},
                    {"data": "Compania"},
                    {"data": "movimientoSolicitado"},
                    {"data": "idCliente"},
                    {"data": "Cliente"},
                    {"data": "fecha"}
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
                DatosOrdenTrabajoText();
            });
        });

        function returnIdOrden() {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblInfOrdenTrabajo");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                $("#inputIdOrden").val("0");
            } else {
                $("#inputIdOrden").val(aData[0].idOrden);
            }
        }
    </script>
</div>