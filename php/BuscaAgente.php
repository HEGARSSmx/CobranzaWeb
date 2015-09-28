<?php ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Busqueda de Cliente</h1>
        </div>
        <div class="modal-body" >
            <table class="table table-responsive table-striped" id="tblAgentes">
                <thead>
                    <tr>
                        <th>Id agente</th>
                        <th>Nombre</th>
                        <th>Clave</th>
                    </tr>
                </thead>
            </table>
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onclick="returnIdAgente()"><span class="glyphicon glyphicon-ok"></span> Seleccionar</button>
        </div>
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
            $("#MyModal").on("hidden.bs.modal", function () {
                DatosAgenteText();
            });
        });

        function returnIdAgente() {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblAgentes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length !== 1) {
                $("#inputIdAgente").val("0");
            } else {
                $("#inputIdAgente").val(aData[0].idAgente);
            }
        }
    </script>
</div>