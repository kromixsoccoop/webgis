<?php
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