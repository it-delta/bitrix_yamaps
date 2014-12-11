<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<script type="text/javascript">
function init() 
{
	ymaps.geocode('<?= $arResult['CENTER_MAP'] ?>', {
        results: 1
    }).then(function (res) {
		var firstGeoObject = res.geoObjects.get(0);

		var myMap = new ymaps.Map("ya-map", {
			center: firstGeoObject.geometry.getCoordinates(),
			zoom: <?= $arResult['ZOOM_MAP'] ?>,
			controls: ['zoomControl', 'fullscreenControl', 'trafficControl']
		});
		
		var objects = ymaps.geoQuery( ymaps.geocode('<?= array_shift($arResult['ITEMS']) ?>') )
			<? foreach ($arResult['ITEMS'] as $v): ?>
				.add(ymaps.geocode('<?= $v ?>'))
			<? endforeach; ?>
			.addToMap(myMap);

		objects.then(function () {
			//objects.get(0).balloon.open();
		});
    });	
}

ymaps.ready(init);
</script>

<div id="ya-map" style="width: <?= $arResult['WIDTH_MAP'] ?>; height: <?= $arResult['HEIGHT_MAP'] ?>;"></div>




