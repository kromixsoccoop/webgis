<?php //  AIzaSyCNjVGwuoILK_f4HhnF--PvuYDmtN6L4-k  ?>

<html>
	<head>
		<title>Google Maps Test</title>
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-3.2.1.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNjVGwuoILK_f4HhnF--PvuYDmtN6L4-k&libraries=geometry"></script>
		<script type="text/javascript" src="labels.js"></script>
		<script type="text/javascript">
		  var map;
		  var ruler1;
		  var ruler2;
		  var rulerpoly;
		  var ilRighello = false;
		  var ruler1label;
		  var ruler2label;
		  
		  
		  $(document).ready(function()
		  {
			map = new google.maps.Map(document.getElementById('map'), {
			  center: {lat: 39.081563, lng: 17.135190},
			  zoom: 16
			});
		  });
		  
		  function righello()
		  {
			ilRighello = true;
			$('button#toggleRighello').html("NASCONDI RIGHELLO");
			$('button#toggleRighello').attr("onclick", "togliRighello()");
			
			ruler1 = new google.maps.Marker({
				position: map.getCenter(),
				map: map,
				draggable: true
			});
		 
			ruler2 = new google.maps.Marker({
				position: map.getCenter() ,
				map: map,
				draggable: true
			});
			 
			ruler1label = new Label({ map: map });
			ruler2label = new Label({ map: map });
			ruler1label.bindTo('position', ruler1, 'position');
			ruler2label.bindTo('position', ruler2, 'position');
		 
			rulerpoly = new google.maps.Polyline({
				path: [ruler1.position, ruler2.position] ,
				strokeColor: "#FFFF00",
				strokeOpacity: .7,
				strokeWeight: 8
			});
			
			rulerpoly.setMap(map);
			
			ruler1label.set('text',"0m");
			ruler2label.set('text',"0m");
		 
			google.maps.event.addListener(ruler1, 'drag', function() {
				rulerpoly.setPath([ruler1.getPosition(), ruler2.getPosition()]);
				ruler1label.set('text',distance());
				ruler2label.set('text',distance());
			});
		 
			google.maps.event.addListener(ruler2, 'drag', function() {
				rulerpoly.setPath([ruler1.getPosition(), ruler2.getPosition()]);
				ruler1label.set('text',distance());
				ruler2label.set('text',distance());
			});
		  }
		  
		  function togliRighello()
		  {
			google.maps.event.clearListeners(ruler1, "drag");
			ruler1.setMap(null);
			google.maps.event.clearListeners(ruler2, "drag");
			ruler2.setMap(null);
			ruler1label.setMap(null);
			ruler2label.setMap(null);
			rulerpoly.setMap(null);
			
			ilRighello = false;
			$('button#toggleRighello').html("RIGHELLO");
			$('button#toggleRighello').attr("onclick", "righello()");
		  }
		  
		  function distance()
		  {
			  var distance = google.maps.geometry.spherical.computeDistanceBetween(ruler1.position, ruler2.position);
			  
			if (distance<10000)
			{
				  return Math.round(distance)+"m";
			}
			else if (distance>=10000)
			{
				var distanza = Math.round(distance/1000);
				return distanza+"km";
			}
		  }
		</script>
	</head>
	
	<body>
	<div id="map" style="width: 100%; height: 100%;"></div>
    <button id="toggleRighello" style="position: absolute; top: 20px; left: 130px;" onclick="righello()">RIGHELLO</button>
    
	</body>
</html>