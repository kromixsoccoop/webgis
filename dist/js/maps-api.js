// Define the overlay, derived from google.maps.OverlayView
function Label(opt_options) {
	// Initialization
	this.setValues(opt_options);

	// Label specific
	var span = this.span_ = document.createElement('span');
	span.style.cssText = 'position: relative; left: 0%; top: -8px; ' +
			  'white-space: nowrap; border: 0px; font-family:arial; font-weight:bold;' +
			  'padding: 2px; background-color: #ddd; '+
				'opacity: .75; '+
				'filter: alpha(opacity=75); '+
				'-ms-filter: "alpha(opacity=75)"; '+
				'-khtml-opacity: .75; '+
				'-moz-opacity: .75;';

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
function righello()
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