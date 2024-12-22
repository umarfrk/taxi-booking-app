<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Map</title>

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

	<style type="text/css">
		#map {
			position: absolute;
			bottom: 0;
			left: 0;
			right: 0;
		}
	</style>
</head>
<body>
	<div id="map"></div>

	<script>
		var map = L.map('map').setView([0, 0], 1);

		L.tileLayer('https://api.maptiler.com/maps/streets-v2/%7Bz%7D/%7Bx%7D/%7By%7D.png?key=zEB1T2SnIMPN3kltEq8m', {
			attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
		}).addTo(map);

		var marker = L.marker([7.8, 80.7]).addTo(map);
	</script>
</body>
</html>