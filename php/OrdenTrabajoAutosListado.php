<?php
include_once './Header.php';
?>
<div class="main">
    <h1>Ordenes de Trabajo de Automoviles</h1>
    <form action="#" method="LINK">
        <button type="submit" formaction="OrdenTrabajoAutos.php" class="btn btn-primary" id="btnNuevo">Agregar</button>
        <button type="submit" formmethod="GET" formaction="#" class="btn btn-primary" id="btnModificar">Modificar</button>
        <button type="submit" formaction="#" class="btn btn-primary" id="btnImprimir">Imprimir</button>
        <button type="submit" formaction="#" class="btn btn-danger" id="btnEliminar">Eliminar</button>
    </form>
    <br>
    <br>
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
    <script src="/Cobranza/js/OrdenTrabajo.js"></script>
    <script>
      InicicializaDataTable();
    </script>
</div>
