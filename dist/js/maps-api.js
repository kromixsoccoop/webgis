// Define the overlay, derived from google.maps.OverlayView
function Label(opt_options) {
	// Initialization
	this.setValues(opt_options);

	// Label specific
	var span = this.span_ = document.createElement('span');
	span.style.cssText = 'position: relative; left: 0%; top: -8px; ' +
			  'white-space: nowrap; border: 0px; font-family:arial; font-weight:bold;' +
			  'padding: 2px; background-color: #000000; color: #FFFFFF; '+
				'opacity: .99; '+
				'filter: alpha(opacity=99); '+
				'-ms-filter: "alpha(opacity=99)"; '+
				'-khtml-opacity: .99; '+
				'-moz-opacity: .99;';

	var div = this.div_ = document.createElement('div');
	div.appendChild(span);
	div.style.cssText = 'position: absolute; display: none';
};
Label.prototype = new google.maps.OverlayView;

// Implement onAdd
Label.prototype.onAdd = function() {
	var pane = this.getPanes().overlayLayer;
	pane.appendChild(this.div_);

	
	// Ensures the label is redrawn if the text or position is changed.
	var me = this;
	this.listeners_ = [
		google.maps.event.addListener(this, 'position_changed',
		function() { me.draw(); }),
		google.maps.event.addListener(this, 'text_changed',
		function() { me.draw(); })
	];
	
};

// Implement onRemove
Label.prototype.onRemove = function() { this.div_.parentNode.removeChild(this.div_ );
	// Label is removed from the map, stop updating its position/text.
	for (var i = 0, I = this.listeners_.length; i < I; ++i) {
		google.maps.event.removeListener(this.listeners_[i]);
	}
};

// Implement draw
Label.prototype.draw = function() {
	var projection = this.getProjection();
	var position = projection.fromLatLngToDivPixel(this.get('position'));

	var div = this.div_;
	div.style.left = position.x + 'px';
	div.style.top = position.y + 'px';
	div.style.display = 'block';

	this.span_.innerHTML = this.get('text').toString();
};

var map;
var ruler1;
var ruler2;
var rulerpoly;
var ilRighello = false;
var ruler1label;
var ruler2label;

/* MAPS API */
function righelloOLD()
{
	ilRighello = true;
	$('button#toggleRighello .btn-text').html("NASCONDI RIGHELLO");
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

	ruler1label.set('text',"0mt");
	ruler2label.set('text',"0mt");

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

function togliRighelloOLD()
{
	google.maps.event.clearListeners(ruler1, "drag");
	ruler1.setMap(null);
	google.maps.event.clearListeners(ruler2, "drag");
	ruler2.setMap(null);
	ruler1label.setMap(null);
	ruler2label.setMap(null);
	rulerpoly.setMap(null);

	ilRighello = false;
	$('button#toggleRighello .btn-text').html("MISURA DISTANZA");
	$('button#toggleRighello').attr("onclick", "righello()");
}

function distance()
{
	var distance = google.maps.geometry.spherical.computeDistanceBetween(ruler1.position, ruler2.position);
	  
	if (distance<10000)
	{
		return Math.round(distance)+"mt";
	}
	else if (distance>=10000)
	{
		var distanza = Math.round(distance/1000);
		return distanza+"km";
	}
}

/* MAPS AVANZATA */
var listaMarker = Array();
var listaLabel = Array();
var listaPosizioniMarker = Array();
var lineaRighello;

function righello()
{
	ilRighello = true;
	listaMarker = Array();
	listaLabel = Array();
	
	//$('button#toggleRighello').html("NASCONDI RIGHELLO");
	$('button#toggleRighello').addClass("btn-warning");
	$('button.all-btn').not("#toggleRighello").not("#screenshot").prop("disabled", true);
	$('button#toggleRighello').attr("onclick", "togliRighello()");
	
	lineaRighello = new google.maps.Polyline({
		//path: listaPosizioniMarker,
		strokeColor: "#FFFF00",
		strokeOpacity: .7,
		strokeWeight: 8
	});
	
	lineaRighello.setMap(map);
	
	google.maps.event.addListener(map,'click',function(event)
	{
		var posizioneAttuale = { lat: event.latLng.lat(), lng: event.latLng.lng() }
		
		var punto = new google.maps.Marker({
			position: posizioneAttuale,
			map: map,
			//icon: 'https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png',
			draggable: false
		});
		
		listaMarker.push(punto);
		
		label_punto = new Label({ map: map });
		label_punto.bindTo('position', punto, 'position');
		label_punto.set('text',"ORIGINE");
		
		listaLabel.push(label_punto);
		
		
		
		if(listaMarker.length > 1)
		{
			var distanzaTotale = 0.00;
			
			
			lineaRighello.setMap(null);
			
			listaPosizioniMarker = Array();
			listaPosizioniMarker.push(listaMarker[0].position);
			
			for(i=1;i<listaMarker.length;i++)
			{
				
				distanzaTotale += distanzaPunti(listaMarker[(i-1)], listaMarker[i]);
				listaPosizioniMarker.push(listaMarker[i].position);
				
			}

			var distanzaParziale = 0.00;
			distanzaParziale = distanzaPunti(listaMarker[(listaMarker.length-1)], listaMarker[(listaMarker.length-2)]);
			
			lineaRighello.setPath(listaPosizioniMarker);
			
			//alert(distanzaTotale);
			
			label_punto.set('text',formatDistance(distanzaParziale));
			$('span#infoMappa').html("DISTANZA TOT. RIGHELLO: " + formatDistance(distanzaTotale));
			
			
			lineaRighello.setMap(map);
			
			
		}
		
		
	});
}

function distanzaPunti(punto1, punto2)
{
	
	var distance = google.maps.geometry.spherical.computeDistanceBetween(punto1.position, punto2.position);
	
	return distance;
}

function formatDistance(distance)
{
	if (distance<10000)
	{
		return Math.round(distance)+" mt";
	}
	else if (distance>=10000)
	{
		var distanza = Math.round(distance/1000);
		return distanza+" km<sup style='color: #fff;'>2</sup>";
	}
}

function togliRighello()
{
	
	google.maps.event.clearListeners(map, "click");
	
	for(i=0;i<listaMarker.length;i++)
	{
		listaMarker[i].setMap(null);
		listaLabel[i].setMap(null);
		lineaRighello.setMap(null);
	}
	
	listaMarker = Array();
	listaLabel = Array();
	listaPosizioniMarker = Array();
	
	ilRighello = false;
	$('button#toggleRighello').removeClass("btn-warning");
	$('button.all-btn').prop("disabled", false);
	$('button#toggleRighello').attr("onclick", "righello()");
	$('span#infoMappa').html("");
}

var lArea = false;
var listaMarkerArea = Array();
var listaPosizioniMarkerArea = Array();
var lineaPoligono;
var labelArea;
var puntoLabel;

var disegno;

function mostraArea()
{
	var centro = { lat: 0, lng: 0 }
	lArea = true;
	listaMarkerArea = Array();
	var distanza = 0.00;
	
	$('button#toggleArea').addClass("btn-warning");
	$('button.all-btn').not("#toggleArea").not("#screenshot").prop("disabled", true);
	$('button#toggleArea').attr("onclick", "togliArea()");
	
	lineaPoligono = new google.maps.Polygon({
		//path: listaPosizioniMarker,
		strokeColor: "#FFFF00",
		strokeOpacity: .7,
		strokeWeight: 8
	});
	
	lineaPoligono.setMap(map);
	
	labelArea = new Label({ map: map });
	puntoLabel = new google.maps.Marker({
		position: centro,
		map: map,
		icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 0
        },
		draggable: false
	});
	labelArea.bindTo('position', puntoLabel, 'position');
	labelArea.set('text',"");

	
	
	var contaPunti = 0;
	
	google.maps.event.addListener(map,'click',function(event)
	{
		
		var posizioneAttuale = { lat: event.latLng.lat(), lng: event.latLng.lng() }
		
		var punto = new google.maps.Marker({
			position: posizioneAttuale,
			map: map,
			//icon: 'https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png',
			draggable: true,
			customInfo: contaPunti
		});
		
		listaMarkerArea.push(punto);
		listaPosizioniMarkerArea.push(punto.position);


		
		
		google.maps.event.addListener(punto, 'drag', function() {
			listaPosizioniMarkerArea[punto.customInfo] = punto.position;
			lineaPoligono.setPath(listaPosizioniMarkerArea);
			lineaPoligono.setMap(map);
			centro = centroid(listaPosizioniMarkerArea);
			puntoLabel.setPosition(centro);
			
			distanza = google.maps.geometry.spherical.computeArea( listaPosizioniMarkerArea );
			
			labelArea.set('text',formatDistance(distanza));
			$('span#infoMappa').html("AREA TOTALE MISURATA: " + formatDistance(distanza));
		});

		
		
		
		
		if(listaMarkerArea.length > 2)
		{
			
			
			lineaPoligono.setMap(null);

			lineaPoligono.setPath(listaPosizioniMarkerArea);
			
			lineaPoligono.setMap(map);
			
			
			
			
			
			centro = centroid(listaPosizioniMarkerArea);
			
			puntoLabel.setPosition(centro);
			
			distanza = google.maps.geometry.spherical.computeArea( listaPosizioniMarkerArea );
			
			labelArea.set('text',formatDistance(distanza));
			$('span#infoMappa').html("AREA TOTALE MISURATA: " + formatDistance(distanza));
			
			
			//labelArea.setMap(null);


			
			
		}
		
		contaPunti++;
	});

}

function centroid(punti)
{
	var bounds = new google.maps.LatLngBounds();
	
	for (i = 0; i < punti.length; i++) {
	  bounds.extend(punti[i]);
	}
	
	var totale = bounds.getCenter();
	
	return totale;
}

function togliArea()
{
	google.maps.event.clearListeners(map, "click");
	
	for(i=0;i<listaMarkerArea.length;i++)
	{
		google.maps.event.clearListeners(listaMarkerArea[i], "drag");
		listaMarkerArea[i].setMap(null);
		labelArea.setMap(null);
		puntoLabel.setMap(null);
		lineaPoligono.setMap(null);
	}
	
	listaMarkerArea = Array();
	listaPosizioniMarkerArea = Array();
	
	lArea = false;
	$('button#toggleArea').removeClass("btn-warning");
	$('button.all-btn').prop("disabled", false);
	$('button#toggleArea').attr("onclick", "mostraArea()");
	$('span#infoMappa').html("");
}

/* scala */
/*
20 : 1128.497220
19 : 2256.994440
18 : 4513.988880
17 : 9027.977761
16 : 18055.955520
15 : 36111.911040
14 : 72223.822090
13 : 144447.644200
12 : 288895.288400
11 : 577790.576700
10 : 1155581.153000
9  : 2311162.307000
8  : 4622324.614000
7  : 9244649.227000
6  : 18489298.450000
5  : 36978596.910000
4  : 73957193.820000
3  : 147914387.600000
2  : 295828775.300000
1  : 591657550.500000
*/

function getScala(zoom)
{
	var ratio = 591657550.500000;

	for(i=1; i<zoom; i++)
	{
		ratio = ratio / 2;
	}

	return ratio.round(2);
}

function zoomIn()
{
	var zoom = map.getZoom();

	if(zoom < 22)
	{
		zoom++;
		map.setZoom(zoom);
	}
}

function cambiaZoom(zoom)
{
	var zooma = parseInt(zoom);

	map.setZoom(zooma);
}

function zoomOut()
{
	var zoom = map.getZoom();

	if(zoom > 0)
	{
		zoom--;
		map.setZoom(zoom);
	}
}

var getCanvas;

function screenShot()
{
	wait();
	$('#imgMap').html("");
	disegno = null;

	disegno = html2canvas(document.getElementById('map').getElementsByTagName( 'div' )[0].getElementsByClassName( 'gm-style' )[0], {
		allowTaint: true,
		backgroundColor: null,
		foreignObjectRendering: false,
		height: 750,
		logging: false
	}).then(function(canvas) {
		getCanvas = canvas;
		$('#imgMap').html(canvas);
		$('#imgMap canvas').attr("id", "canvas").attr("crossorigin", "anonymous").css("width", "100%");
		
		unwait();
		
		
		/*var image = canvas.toDataURL("image/png");
		
    	return image.replace(/^data:image\/(png|jpg);base64,/, "");*/
		
		
	});

}


function downloadScreenshot()
{
	
}




function displayCoordinates(pnt) {

	var lat = pnt.lat();
	lat = lat.toFixed(4);
	var lng = pnt.lng();
	lng = lng.toFixed(4);
	$('span#currentLat').html(toDegreesMinutesAndSeconds(lat));
	$('span#currentLng').html(toDegreesMinutesAndSeconds(lng));
	//console.log("Latitude: " + lat + "  Longitude: " + lng);
}


function roadmap()
{
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
	
}

function satellite()
{
	map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
}

function toDegreesMinutesAndSeconds(coordinate) {
    var absolute = Math.abs(coordinate);
    var degrees = Math.floor(absolute);
    var minutesNotTruncated = (absolute - degrees) * 60;
    var minutes = Math.floor(minutesNotTruncated);
    var seconds = Math.floor((minutesNotTruncated - minutes) * 60);

    return degrees + "&deg; " + minutes + "' " + seconds + "''";
}

function convertDMS(lat, lng) {
    var latitude = toDegreesMinutesAndSeconds(lat);
    var latitudeCardinal = lat >= 0 ? "N" : "S";

    var longitude = toDegreesMinutesAndSeconds(lng);
    var longitudeCardinal = lng >= 0 ? "E" : "W";

    return latitude + " " + latitudeCardinal + "\n" + longitude + " " + longitudeCardinal;
}