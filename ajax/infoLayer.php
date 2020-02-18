<?php session_start();

    header("Access-Control-Allow-Origin: *");

	require_once("../include/db.php");
    require_once("../include/functions.php");



    $info = json_decode($_POST['info']);

    $idLayer = (int)$info->idLayer;

    $s1 = $db->Query("SELECT template FROM wg_progetti_layers WHERE id = '$idLayer'");

    $f1 = $db->getObject($s1);

    //$poligoni = unserialize($f1->boundaries);

    $template = dequotes($f1->template);

    foreach($info->attributi as $chiave => $valore)
    {
        
        $template = str_replace('{{'.$chiave.'}}', $valore, $template);
    }

    // cancello il placeholder
    $template = preg_replace("#{{[A-Za-z0-9\. \-]+}}#i", "", $template);

    echo $template;
?>