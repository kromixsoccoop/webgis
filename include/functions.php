<?php

    if(isset($_GET['act']) && $_GET['act'] == 'out')
    {
        $_SESSION['usid'] = '';
        session_destroy();
        setcookie("usid", "", time() - 60);
        setcookie("check", "", time() - 60);

        phpRedir("login.php");
    }

    /* ------------------- */


    function is_logged()
    {
        if(isset($_SESSION['usid']))
        {
            if((int)$_SESSION['usid'] != 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    function aquotes($stringa)
    {
        $stringa = utf8_encode($stringa);

        return $stringa;
    }

    function dequotes($stringa)
    {
        $stringa = utf8_decode($stringa);

        return $stringa;
    }

    function phpRedir($location)
    {
        header("Location: $location");
        exit();
    }

    function isLevel($livello)
    {
        global $db;

        if(is_logged())
        {

            $io = (int)$_SESSION['usid'];

            $us = $db->Query("SELECT livello FROM wg_utenti WHERE id = '$io'");

            $fus = $db->getObject($us);

            if($fus->livello == $livello || $fus->livello == 'founder')
            {
                return true;
            }
            else
            {
                return false;
            }

        }
    }

    function scrivi_reg($operazione, $cat = '')
    {
        global $db;

        $utente = (is_logged()) ? $_SESSION['usid'] : 0;

        $scri = $db->Query("INSERT INTO wg_registro (`id_utente`, `categoria`, `operazione`, `data`, `errore`) VALUES ('$utente', '$cat', '$operazione', NOW(), '0')");

    }

    function error_reg($operazione, $cat = '')
    {
        global $db;

        $utente = (is_logged()) ? $_SESSION['usid'] : 0;

        $scri = $db->Query("INSERT INTO wg_registro (`id_utente`, `categoria`, `operazione`, `data`, `errore`) VALUES ('$utente', '$cat', '$operazione', NOW(), '1')");

    }

    /* --------------- */

    function getScala($zoom)
    {
        $ratio = 591657550.500000;
    
        for($i=1; $i<$zoom; $i++)
        {
            $ratio = $ratio / 2;
        }
    
        return round($ratio, 2);
    }

    function labelVisibilita($level)
    {
        switch($level)
        {
            case 0:
                return "Pubblico";
            break;
            case 1:
                return "Solo Admin";
            break;
            case 2:
                return "Admin e Tecnici";
            break;
            case 3:
                return "Admin, Tecnici e Consorziati";
            break;
        }
    }

    function getLayersDown($madre = 0)
    {
        global $db;

        $g = $db->Query("SELECT id, nome_layer FROM wg_progetti_layers WHERE id_madre = '$madre'");

        $listaFigli = array();

        while($fg = $db->getObject($g))
        {
            $listaFigli[] = array($fg->id, $fg->nome_layer);
        }

        return $listaFigli;
    }

    function treeviewLayers($madre = 0, $prj = 0)
    {
        global $db;

        $g = $db->Query("SELECT id, nome_layer, attributi FROM wg_progetti_layers WHERE id_madre = '$madre'");

        while($fg = $db->getObject($g))
        {
    ?>
    
        <ul>
            <li> 
                <i class="fa fa-angle-right txt-dark"></i>
                <label style="color: #234151; width: 97%"><input id="xnode-0-1" data-id="custom-0-1" type="checkbox" /> <?=dequotes($fg->nome_layer)?> <a href="javascript:;" onclick="delLayer(<?=$fg->id?>, <?=$prj?>)" title="Elimina Layer" style="float: right;"><i class="fa fa-close txt-danger"></i></a><?php if(!empty($fg->attributi)): ?> <a href="addProgetto.php?act=modLayer&prj=<?=$prj?>&lyr=<?=$fg->id?>" title="Modifica template Layer" style="float: right;margin-right: 10px"><i class="fa fa-cog txt-primary"></i></a><?php endif; ?></label>
                <?php
                    treeviewLayers($fg->id, $prj);
                ?>
            </li>
        </ul>
    <?php
        }

    }

    function selectLayers($madre, $livello = 1)
    {
        global $db;

        $g = $db->Query("SELECT id, nome_layer FROM wg_progetti_layers WHERE id_madre = '$madre'");

        while($fg = $db->getObject($g))
        {
        ?>
        <option value="<?=$fg->id?>"><?=str_repeat("&nbsp;", $livello * 2)?>⎇ <?=dequotes($fg->nome_layer)?></option>
        <?php
            $livello++;

            selectLayers($fg->id, $livello);
        }
    }

    function treeviewMapLayers($madre = 0, $prj = 0)
    {
        global $db;

        $g = $db->Query("SELECT id, nome_layer, attributi FROM wg_progetti_layers WHERE id_madre = '$madre'");

        while($fg = $db->getObject($g))
        {
    ?>
    
        <ul>
            <li> <?=(layerHasChild($fg->id)) ? '<i class="fa fa-angle-right"></i>' : ''; ?>
            <label>
				<input onclick="setLayer(<?=$fg->id?>)" id="xnode-<?=$fg->id?>" data-id="custom-<?=$fg->id?>" type="checkbox" />
                <?=dequotes($fg->nome_layer)?>
            </label>
                <?php
                    treeviewMapLayers($fg->id, $prj);
                ?>
            </li>
        </ul>
    <?php
        }

    }

    function layerHasChild($layerID)
    {
        global $db;

        $g = $db->Query("SELECT id FROM wg_progetti_layers WHERE id_madre = '$layerID'");

        return $db->Found($g);
    }

    function sanitize_attributes($name)
    {
        $name = preg_replace("#[^A-Za-z0-9\. \-]+#", "", $name);

        return $name;
    }
    
?>