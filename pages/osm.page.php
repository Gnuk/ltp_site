<html><body>
  <div id="mapdiv"></div>
  <script src="lib/openlayers/OpenLayers.js"></script>
  <script>
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());
 
    var position1 = new OpenLayers.LonLat( 5.92 ,45.57 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
    var position2 = new OpenLayers.LonLat( 5.8714950, 45.6470858 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
    var center = new OpenLayers.LonLat( 5.8714950, 45.6 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
 
    var zoom=12;
 
    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
 
    markers.addMarker(new OpenLayers.Marker(position1));
    markers.addMarker(new OpenLayers.Marker(position2));
 
    map.setCenter (center, zoom);
  </script>
</body></html>