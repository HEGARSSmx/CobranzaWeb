<?php
include '../Header.php';
?>
<div class="main">
    <h1 class="page-header">Listado De Usuarios Del Sistema</h1>
    <button class="btn btn-primary" id="btnAgregar"><span class="glyphicon glyphicon-plus" onclick="agregar()"></span> Agregar</button>
    <button class="btn btn-primary" id="btnEditar"><span class="glyphicon glyphicon-edit" onclick="editar()"></span> Editar</button>
    <button class="btn btn-danger" id="btnEliminar"><span class="glyphicon glyphicon-remove" onclick="borrar()"></span> Borrar</button>
    <br>
    <br>
    <table id="tblUsers" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>E-mail</th>
                <th>Nombre</th>
            </tr>
        </thead>
    </table>
    <script type="text/javascript">
        function agregar() {

        }

        function editar() {

        }

        function borrar() {

        }

        $(document).ready(function () {
            var table = $('#tblUsers').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/Cobranza/php/Catalogos/TablaUsuarios.php",
                "columns": [
                    {"data": "userId"},
                    {"data": "email"},
                    {"data": "nombre"}
                ],
                "language": {
                    "url": "/Cobranza/Spanish.json"
                },
                "sDom": 'T<"clear">lfrtip',
                "oTableTools": {
                    "sRowSelect": "single",
                    "aButtons": ""
                }
            });
        });
    </script>
</div>