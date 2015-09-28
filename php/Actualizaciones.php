<?php
include './Header.php';
echo '<h1>Gestor de Actualizaciones</h1>';
ini_set('max_execution_time', 60);
//Check For An Update
$getVersions = file_get_contents('http://hegarss.com/COBRANZA-UPDATE-PACKAGES/current-release-versions.php') 
        or die('Error al tratar de conectarse al servidor para verificar actualizaciones. Intente nuevamente mas tarde');
if ($getVersions != '') {
    include './Funciones.php';
    echo '<p>Version Actual: v' . get_siteInfo('version') . '</p>';
    $versionList = explode("\n", $getVersions);
    $updated = FALSE;
    foreach ($versionList as $aV) {
        if ($aV > get_siteInfo('version')) {
            echo '<p>Nueva Actualizacion: v' . $aV . '</p>';
            $found = true;

            //Download The File If We Do Not Have It
            if (!is_file('Cobranza-' .trim($aV).'.zip')) {
                echo '<p>Descargando Nueva Actualizacion</p>';
                $updateFile = 'http://hegarss.com/COBRANZA-UPDATE-PACKAGES/Cobranza-'.trim($aV).'.zip';
                $newUpdate = file_get_contents($updateFile) or die("Error al descargar el archivo de actualizacion ". $updateFile);
                
                $dlHandler = fopen('Cobranza-'.trim($aV).'.zip', 'w');
                if (!fwrite($dlHandler, $newUpdate)) {
                    echo '<p>No se puede guardar la actualizacion. Operacion Abortada.</p>';
                    exit();
                }
                fclose($dlHandler);
                echo '<p>Actualizacion Descargada y Guardada</p>';
            } else {
                echo '<p>La Actualizacion ya se encuentra descargada</p>';
            }
            if (filter_input(INPUT_GET, "doUpdate") == true) {
                //Open The File And Do Stuff
                $zipHandle = zip_open('Cobranza-'.trim($aV).'.zip');
                echo '<ul>';
                while ($aF = zip_read($zipHandle)) {
                    $thisFileName = zip_entry_name($aF);
                    $thisFileDir = dirname($thisFileName);

                    //Continue if its not a file
                    if (substr($thisFileName, -1, 1) == '/') {
                        continue;
                    }

                    //Make the directory if we need to...
                    if (!is_dir(filter_input(INPUT_SERVER, "CONTEXT_DOCUMENT_ROOT") . '/' . $thisFileDir)) {
                        mkdir(filter_input(INPUT_SERVER, "CONTEXT_DOCUMENT_ROOT") . '/' . $thisFileDir);
                        echo '<li>Directorio Creado ' . $thisFileDir . '</li>';
                    }

                    //Overwrite the file
                    if (!is_dir(filter_input(INPUT_SERVER, "CONTEXT_DOCUMENT_ROOT") . '/' . $thisFileName)) {
                        echo '<li>' . $thisFileName . '...........';
                        $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                        $contents = str_replace("\r\n", "\n", $contents);
                        $updateThis = '';
                        //If we need to run commands, then do it.
                        if ($thisFileName == 'upgrade.php') {
                            $upgradeExec = fopen('upgrade.php', 'w');
                            fwrite($upgradeExec, $contents);
                            fclose($upgradeExec);
                            include ('upgrade.php');
                            unlink('upgrade.php');
                            echo' Ejecutado</li>';
                        } else {
                            $updateThis = fopen(filter_input(INPUT_SERVER, "CONTEXT_DOCUMENT_ROOT") . '/' . $thisFileName, 'w');
                            fwrite($updateThis, $contents);
                            fclose($updateThis);
                            unset($contents);
                            echo' ACTUALIZADO</li>';
                        }
                    }
                }
                echo '</ul>';
                zip_close($zipHandle);
                unlink('Cobranza-'.trim($aV).'zip');
                $updated = TRUE;
            } else {
                echo '<p>Actualizacion Lista. <a href="?doUpdate=true">&raquo; Instalar...?</a></p>';
            }
            break;
        }
    }

    if ($updated == true) {
        set_setting('version', $aV);
        echo '<p class="success">&raquo; Cobranza Actualizada a v' . $aV . '</p>';
    } else if ($found != true) {
        echo '<p>&raquo; No se encontraron Actualizaciones.</p>';
    }
} else {
    echo '<p>No se pudieron encontrar las ultimas actualizaciones.</p>';
}