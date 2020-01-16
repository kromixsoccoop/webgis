<?php session_start();
	require_once("../include/db.php");
	require_once("../include/functions.php");

	if(!is_logged())
	{
		exit();
	}

	if(!isLevel('admin'))
	{
		exit();
	}

    $id = (int)$_POST['id'];
    
    $d = $db->Query("DELETE FROM wg_progetti_foto WHERE id = '$id'");

    if($d)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
?>