<html>
	<head>
		<title>PHP, jQuery and Google Maps</title>
		<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAZBe7uHI90ESk2XAmWRL3RxR6u04U0tImA3bfwZ3-HKdEno7z2xRk2YE6OkudtBX5qy0vLrgbf1DUCg"></script>
		<script type="text/javascript">
			google.load("jquery", '1.2.6');
			google.load("maps", "2.x");
		</script>
		<style type="text/css" media="screen">
			#map { float:left; width:800px; height:400px; }
			#list { float:left; width:200px; background:#eee; list-style:none; padding:0; }
			#list li { padding:10px; }
			#list li:hover { background:#555; color:#fff; cursor:pointer; cursor:hand; }
			#message { background:#555; color:#fff; position:absolute; display:none; width:100px; padding:5px; }
			#add-point { float:left; }
			div.input { padding:3px 0; }
			label { display:block; font-size:80%; }
			input, select { width:150px; }
			button { float:right; }
			div.error { color:red; font-weight:bold; }
		</style>
		<script type="text/javascript" charset="utf-8">
			$(function(){
				var map = new GMap2(document.getElementById('map'));
				var burnsvilleMN = new GLatLng(20.920397,78.222656);
				map.setCenter(burnsvilleMN, 9);
				var bounds = new GLatLngBounds();
				var geo = new GClientGeocoder(); 
				
				var reasons=[];
				reasons[G_GEO_SUCCESS]            = "Success";
				reasons[G_GEO_MISSING_ADDRESS]    = "Missing Address";
				reasons[G_GEO_UNKNOWN_ADDRESS]    = "Unknown Address.";
				reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address";
				reasons[G_GEO_BAD_KEY]            = "Bad API Key";
				reasons[G_GEO_TOO_MANY_QUERIES]   = "Too Many Queries";
				reasons[G_GEO_SERVER_ERROR]       = "Server error";
				
				// initial load points
				$.getJSON("map-service.php?action=listpoints", function(json) {
					if (json.Locations.length > 0) {
						for (i=0; i<json.Locations.length; i++) {
							var location = json.Locations[i];
							addLocation(location);
						}
						zoomToBounds();
					}
				});
				
				$("#add-point").submit(function(){
					geoEncode();
					return false;
				});
				
				function savePoint(geocode) {
					var data = $("#add-point :input").serializeArray();
					data[data.length] = { name: "lng", value: geocode[0] };
					data[data.length] = { name: "lat", value: geocode[1] };
					$.post($("#add-point").attr('action'), data, function(json){
						$("#add-point .error").fadeOut();
						if (json.status == "fail") {
							$("#add-point .error").html(json.message).fadeIn();
						}
						if (json.status == "success") {
							$("#add-point :input[name!=action]").val("");
							var location = json.data;
							addLocation(location);
							zoomToBounds();
						}
					}, "json");
				}
				
				function geoEncode() {
					var address = $("#add-point input[name=address]").val();
					geo.getLocations(address, function (result){
						if (result.Status.code == G_GEO_SUCCESS) {
							geocode = result.Placemark[0].Point.coordinates;
							savePoint(geocode);
						} else {
							var reason="Code "+result.Status.code;
							if (reasons[result.Status.code]) {
								reason = reasons[result.Status.code]
							} 
							$("#add-point .error").html(reason).fadeIn();
							geocode = false;
						}
					});
				}
				
				function addLocation(location) {
					var point = new GLatLng(location.lat, location.lng);		
					var marker = new GMarker(point);
					map.addOverlay(marker);
					bounds.extend(marker.getPoint());
					
					$("<li />")
						.html(location.name)
						.click(function(){
							showMessage(marker, location.name);
						})
						.appendTo("#list");
					
					GEvent.addListener(marker, "click", function(){
						showMessage(this, location.name);
					});
				}
				
				function zoomToBounds() {
					map.setCenter(bounds.getCenter());
					map.setZoom(map.getBoundsZoomLevel(bounds)-1);
				}
				
				$("#message").appendTo( map.getPane(G_MAP_FLOAT_SHADOW_PANE) );
				
				function showMessage(marker, text){
					var markerOffset = map.fromLatLngToDivPixel(marker.getPoint());
					$("#message").hide().fadeIn()
						.css({ top:markerOffset.y, left:markerOffset.x })
						.html(text);
				}
			});
		</script>
	</head>
	<body style="width:1000px;margin-left:auto;margin-right:auto">
		<!--<form id="add-point" action="php/map-service.php" method="POST">
			<input type="hidden" name="action" value="savepoint" id="action">
			<fieldset>
				<legend>Add a Point to the Map</legend>
				<div class="error" style="display:none;"></div>
				<div class="input">
					<label for="name">Location Name</label>
					<input type="text" name="name" id="name" value="">
				</div>
				<div class="input">
					<label for="address">Address</label>
					<input type="text" name="address" id="address" value="">
				</div>
				<button type="submit">Add Point</button>
			</fieldset>
		</form>-->
		<div id="map"></div>
		<ul id="list"></ul>
		<div id="message"></div>
	</body>
</html>
