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
			
			AutoSizeAnchored = OpenLayers.Class(OpenLayers.Popup.Anchored, { 'autoSize': true});

			markers = new OpenLayers.Layer.Markers("zibo");
			map.addLayer(markers);

			var longlat, popupClass, popupContentHTML;

			longlat = new OpenLayers.LonLat(-55,20);
			popupClass = AutoSizeAnchored;
			popupContentHTML = 'Salut, ça va ?';
			addMarker(longlat, popupClass, popupContentHTML);

			function addMarker(ll, popupClass, popupContentHTML, closeBox, overflow) {
						var feature = new OpenLayers.Feature(markers, ll); 
						feature.closeBox = closeBox;
						feature.popupClass = popupClass;
						feature.data.popupContentHTML = popupContentHTML;
						feature.data.overflow = (overflow) ? "auto" : "hidden";
								
						var marker = feature.createMarker();

						var markerClick = function (evt) {
							if (this.popup == null) {
								this.popup = this.createPopup(this.closeBox);
								map.addPopup(this.popup);
								this.popup.show();
							} else {
								this.popup.toggle();
							}
							currentPopup = this.popup;
							OpenLayers.Event.stop(evt);
						};
						marker.events.register("mousedown", feature, markerClick);

						markers.addMarker(marker);
			}
		
// 			var position1 = addPosition( 5.92 ,45.57 );
// 			var position2 = addPosition( 5.8714950, 45.6470858 );
 			var center = addPosition( 5.8714950, 45.6 );
// 		
 			var zoom=12;
// 		
// 			var markers = new OpenLayers.Layer.Markers( "<?php echo T_("Amis"); ?>" );
// 			map.addLayer(markers);
// 		
// 			markers.addMarker(new OpenLayers.Marker(position1, getIcon()));
// 			markers.addMarker(new OpenLayers.Marker(position2, getIcon()));
// 			
// 		
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