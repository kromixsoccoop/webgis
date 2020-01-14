<?php

    function is_logged()
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

            if($fus->livello == $livello)
            {
                return true;
            }
            else
            {
                return false;
            }

        }
    }

    function getScala($zoom)
    {
        $ratio = 591657550.500000;
    
        for($i=1; $i<$zoom; $i++)
        {
            $ratio = $ratio / 2;
        }
    
        return round($ratio, 2);
    }

    
?>