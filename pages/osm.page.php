<?php
	if(Page::haveRights()){
?>
<html>
	<head>
		<style>
			#mapdiv{
				height: 600px;
				width: 800px;
			}
			.olPopup{
				background: black;
				width: 200px;
				height: auto;
				box-shadow: 0px 3px 5px black;
			}
			.olPopup, .olPopup .olpopupcontent{
				border-radius: 10px;
			}
		</style>
	</head>
	<body>
		<div id="mapdiv"></div>
		<script src="lib/openlayers/OpenLayers.js"></script>
		<script>
			var options = {
				controls: [
				new OpenLayers.Control.Navigation(),
				new OpenLayers.Control.PanZoomBar(),
				new OpenLayers.Control.LayerSwitcher(),
				new OpenLayers.Control.Attribution()
				]
			};
			function addPosition(longitude, lattitude){
				return new OpenLayers.LonLat( longitude ,lattitude ).transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
			}
			function getIcon(){
				var size = new OpenLayers.Size(21, 25);
				var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
				return new OpenLayers.Icon('<?php echo LINKR_IMAGES . 'marker.png';?>',size,offset);
			}
			
			map = new OpenLayers.Map("mapdiv", options);
			map.addLayer(new OpenLayers.Layer.OSM());
			
		
			var position1 = addPosition( 5.92 ,45.57 );
			var position2 = addPosition( 5.8714950, 45.6470858 );
			var center = addPosition( 5.8714950, 45.6 );
		
			var zoom=12;
		
			var markers = new OpenLayers.Layer.Markers( "<?php echo T_("Amis"); ?>" );
			map.addLayer(markers);
		
			markers.addMarker(new OpenLayers.Marker(position1, getIcon()));
			markers.addMarker(new OpenLayers.Marker(position2, getIcon()));
		
			map.setCenter (center, zoom);
		</script>
	</body>
</html>
<?php
	}
	else{
		Page::showDefault();
	}
?>