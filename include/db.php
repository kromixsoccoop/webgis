<?php
    require_once("SQLManager.class.php");

    $db = new SQLManager(true, "", "logdb.txt", false);

    $db->Open("localhost", "root", "test", "webgis");
?>