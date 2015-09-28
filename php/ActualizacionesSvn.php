<?php
include './Header.php';
echo '<h1>Gestor de Actualizaciones</h1>';
echo '<p>Buscar e instalar. <a href="?doUpdate=true">&raquo; Actualizaciones...?</a></p>';
$doUpdate = filter_input(INPUT_GET, "doUpdate");
svn_auth_set_parameter(PHP_SVN_AUTH_PARAM_IGNORE_SSL_VERIFY_ERRORS, TRUE);
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, "lupe");
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, "ggarza.");
if ($doUpdate) {
    $x = svn_update(filter_input(INPUT_SERVER, "CONTEXT_DOCUMENT_ROOT"), SVN_REVISION_HEAD, TRUE);
    echo 'Actualizado a la revision: ' . $x;
    echo '<br>';
}
echo '<p><h2>Log de Cambios</h2>';
$aLog = svn_log(filter_input(INPUT_SERVER, "CONTEXT_DOCUMENT_ROOT"), SVN_REVISION_PREV, SVN_REVISION_HEAD);
foreach ($aLog as $rev) {
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Revision # <?php echo $rev['rev']; ?></h3>
        </div>
        <div class="panel-body">
            Por: <?php echo $rev['author']; ?><br>
            Mensaje: <?php echo $rev['msg']; ?><br>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Accion</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rev['paths'] as $path) { ?>
                        <tr>
                            <td><?php echo $path['action']; ?></td>
                            <td><?php echo $path['path']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            El dia: <?php echo $rev['date']; ?>
        </div>
    </div>
    <?php
}