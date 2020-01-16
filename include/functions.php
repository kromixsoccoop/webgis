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
    
?>