<?php session_start();

    header("Access-Control-Allow-Origin: *");

	require_once("../include/db.php");
    require_once("../include/functions.php");


    
?>

<div id="map" style="height:750px; width: 100%"></div>

<script type="text/javascript" id="runscript">
    
        
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 39.081563, lng: 17.135190},
            zoom: 16,
            disableDefaultUI: true,
            zoomControl: false,
            panControl: false,
            fullscreenControl: true,
            scaleControl: false,
            streetViewControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

<?php

    // prendo i layer comunicati come visibili
    $idLayers = explode(",", $_POST['idLayers']);

    foreach($idLayers as $layer)
    {
        if((int)$layer != 0)
        {
            $s1 = $db->Query("SELECT * FROM wg_progetti_layers WHERE id = $layer");

            $f1 = $db->getObject($s1);

            // prendo i dati del poligono
            $contatore = 0;

            $poligoni = unserialize($f1->boundaries);

            foreach($poligoni as $poligono)
            {
                $attributi = $poligono['attributi'];

                if(isset($poligono['bordi']))
                {
                    $bordi = $poligono['bordi'];
                }
                elseif(isset($poligono['coo']))
                {
                    $coordinate = $poligono['coo'];
                }
                elseif(isset($poligono['interni']))
                {
                    $interni = $poligono['interni'];
                }
                //$coo = $poligono['coo'];
                //$interni = $poligono['interni'];

                //print_r($poligoni);
                //exit("");
                
                $t1 = '';
                $t2 = '';
                $t3 = '';
                $val = array();
                $valpol = array();
                
                if(isset($poligono['bordi']))
                {
                    $t1 = "var pathe".$contatore." = [";

                    foreach($bordi[0] as $coo)
                    {
                        /*if(empty($lati) && empty($longi))
                        {
                            $lati = trim((float)$coo[0]);
                            $longi = trim((float)$coo[1]);
                        }*/
                        $valpol['esterno'][] = "{lat:".trim((float)$coo[0]).", lng:".trim((float)$coo[1])."}";
                    }

                    $t1 .= implode(",", $valpol['esterno']);

                    $t1 .= "];";
                }

                if(isset($poligono['interni']))
                {
                    $t2 = "var pathi".$contatore." = [";
                    foreach($interni[0] as $coo)
                    {
                        /*if(empty($lati) && empty($longi))
                        {
                            $lati = trim((float)$coo[0]);
                            $longi = trim((float)$coo[1]);
                        }*/
                        $valpol['interno'][] = "{lat:".trim((float)$coo[0]).", lng:".trim((float)$coo[1])."}";
                    }

                    $t2 .= implode(",", $valpol['interno']);

                    $t2 .= "];";
                }

                if(isset($poligono['coo']))
                {
                    
                    $t3 = "var path".$contatore." = [";

                    foreach($coordinate[0] as $coo)
                    {
                        /*if(empty($lati) && empty($longi))
                        {
                            $lati = trim((float)$coo[0]);
                            $longi = trim((float)$coo[1]);
                        }*/
                        $val[] = "{lat:".trim((float)$coo[0]).", lng:".trim((float)$coo[1])."}";
                    }

                    $t3 .= implode(",", $val);

                    $t3 .= "];";
                }

                
                
                
                
                
                
                
                echo $t1."\r\n\r\n";
                echo $t2."\r\n\r\n";
                echo $t3."\r\n\r\n";

            if(!isset($poligono['punti']))
            {
                if(isset($poligono['bordi']) || isset($poligono['interni']))
                {
                    $tipolinea = "Polygon";
                }
                else
                {

                    $tipolinea = "Polyline";
                    
                }

                if($f1->forzapoligono == 1)
                {
                    $tipolinea = "Polygon";
                }

                if($f1->forzalinea == 1)
                {
                    $tipolinea = "Polyline";
                }

                ?>
                polygon<?=$contatore?> = new google.maps.<?=$tipolinea?>({

                <?php 
                if(isset($poligono['bordi']) && isset($poligono['interni']))
                {
                ?>
                paths: [pathe<?=$contatore?>, pathi<?=$contatore?>],
                <?php
                }
                elseif(isset($poligono['bordi']) && !isset($poligono['interni']))
                {
                ?>
                path: pathe<?=$contatore?>,
                <?php
                }
                elseif(!isset($poligono['bordi']) && isset($poligono['interni']))
                {
                ?>
                path: pathi<?=$contatore?>,
                <?php
                }
                else
                {
                ?>
                path: path<?=$contatore?>,
                <?php
                }
                ?>
                
                strokeColor: '<?=$f1->colore?>',
                strokeOpacity: .8,
                strokeWeight: 5,
                fillColor: '<?=$f1->coloreinterno?>',
                fillOpacity: 0.35,
                map: map
                
                });
                

                google.maps.event.addListener(polygon<?=$contatore?>, 'click', function(h) {
                    //alert("contatore: <?=$contatore?>");
                    <?php
                        $jsonLayer['attributi'] = $attributi;
                        $jsonLayer['idLayer'] = $layer;
                    ?>
                    var infoPost = '<?=json_encode($jsonLayer)?>';

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/infoLayer.php',
                        data: {'info': infoPost},
                        success: function(dati) {
                            $('#infoLayer').removeClass("hidden");
                            $('#infoProgetto').removeClass("hidden").addClass("hidden");
                            $('.contenutoLayer').html(dati);

                            if($('.setting-panel').hasClass("aperto"))
                            {
                                
                            }
                            else
                            {
                                $('#infoProgetto').removeClass("hidden").addClass("hidden");
                                $(".setting-panel").css("margin-right", "0px").addClass("aperto");
                            }
                        }
                    });

                });
                <?php

            }
            else
            {
                    foreach($poligono['punti'] as $marker)
                    {
                        
                        
                        foreach($marker as $coo)
                        {
                            
                            $lati = trim((float)$coo[0]);
                            $longi = trim((float)$coo[1]);

                            $t4 = "var punto".$contatore." = ";
                            $t4 .= "{lat:".$lati.", lng:".$longi."}";
                            $t4 .= ";";

                            echo $t4."\r\n\r\n";
                    ?>
                    var infowindow<?=$contatore?> = new google.maps.InfoWindow({
                        content: '<p>CIAO</p>'
                    });


                    var marker<?=$contatore?> = new google.maps.Marker({
                        position: punto<?=$contatore?>,
                        map: map
                    });

                    marker<?=$contatore?>.addListener('click', function() {
                        //infowindow<?=$contatore?>.open(map, marker<?=$contatore?>);

                        <?php
                        $jsonLayer['attributi'] = $attributi;
                        $jsonLayer['idLayer'] = $layer;
                        ?>
                        var infoPost = '<?=json_encode($jsonLayer)?>';

                        $.ajax({
                            type: 'POST',
                            url: 'ajax/infoLayer.php',
                            data: {'info': infoPost},
                            success: function(dati) {
                                $('#infoLayer').removeClass("hidden");
                                $('#infoProgetto').removeClass("hidden").addClass("hidden");
                                $('.contenutoLayer').html(dati);

                                if($('.setting-panel').hasClass("aperto"))
                                {
                                    
                                }
                                else
                                {
                                    $('#infoProgetto').removeClass("hidden").addClass("hidden");
                                    $(".setting-panel").css("margin-right", "0px").addClass("aperto");
                                }
                            }
                        });

                    });

                    <?php
                            
                        }
                    }
            }
                
                $contatore++;
            }
        }
    }

?>

        setTimeout(
            function() 
            {
                map.setOptions({streetViewControl: true});

                google.maps.event.addListener(map, 'mousemove', function (event) {
                    displayCoordinates(event.latLng);               
                });

                $('#scalaMap').val(map.getZoom());
            }
        , 1000);
    
</script>