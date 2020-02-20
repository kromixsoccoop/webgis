<?php
    require_once("SQLManager.class.php");

    $db = new SQLManager(true, "", "logdb.txt", false);

    $db->Open("localhost", "xabheeit_webgis", "Webgis1.0", "xabheeit_webgis");
?>