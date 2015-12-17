		//TWEAKING THE MAP
        var zoom_level = 6.8;
		var index_grades = [0, 10, 20, 50, 100, 200, 500, 1000];//0-10
		var map = L.map('map', { 
			zoomControl: true,
			dragging: false,
			}).setView([28.5, 84.3], zoom_level);//originally 7, removed zoom control

		L.tileLayer('', {
			maxZoom: 10,
			minZoom: 6.5, //added to remove zoom out
			
			id: 'kazi-map',
		}).addTo(map);

		map.dragging.enable();


		// control that shows state info on hover
		var info = L.control();
		var value = {
            max_height: 30,
            max_width: 225
            
        };
		$('.girl').css('height',value.max_height);
        $('.girl').css('width', 0.5*value.max_width);
		$('.boy').css('height',value.max_height);
        $('.boy').css('width', 0.5*value.max_width);
		$('.total-tile').css('height',value.max_height);
        $('.total-tile').css('width', value.max_width);
		info.onAdd = function (map) {
			this._div = L.DomUtil.create('div', 'info');
			this.update();
			return this._div;
		};

		info.update = function (props) {
			
			this._div.innerHTML = 
				(props ? '<div class="district-name">' + props.name + '</div><br />' +
				'<div class="girls item"><div class="label"><div class="icon"></div><div class="label-name">Girls</div></div><div class="value">' + KAZI.util(value,props.girls,"g",props.total) + '%</div></div><div class="clear"></div>'+
				'<div class="boys item"><div class="label"><div class="icon"></div><div class="label-name">Boys</div></div><div class="value">' + KAZI.util(value,props.boys,"b",props.total) + '%</div></div><div class="clear"></div>'+
				'<div class="total item"><div class="label"><div class="icon"></div><div class="label-name">Total</div></div><div class="value">' + props.total+ '%</div></div><div class="clear"></div>' : '<div class="hover-district">Hover over a district</div>');//props.girls, props.boys
			
		};
		info.addTo(map);


		// get color depending on population density value
		//TODO: theme_color needs to be changed
		theme_color = '0,0,0';
		function getColor(d) {
			
			//black
			return d > 1000 ? 'rgba('+ theme_color +',1)' :
			       d > 500  ? 'rgba('+ theme_color +',0.9)' :
			       d > 200  ? 'rgba('+ theme_color +',0.8)' :
			       d > 100  ? 'rgba('+ theme_color +',0.7)' :
			       d > 50   ? 'rgba('+ theme_color +',0.6)' :
			       d > 20   ? 'rgba('+ theme_color +',0.5)' :
			       d > 10   ? 'rgba('+ theme_color +',0.4)' :
			                  '#ccc';
		}

		function style(feature) {
			return {
				weight: 1,
				opacity: 1,
				color: '#5d5d5d',
				dashArray: '0',//3
				fillOpacity: 0.7,
				fillColor: getColor(feature.properties.total)
			};
		}

		function highlightFeature(e) {
			var layer = e.target;

			layer.setStyle({
				weight: 2,//5 - hover border width
				color: border_color,//border color #666
				dashArray: '',
				fillOpacity: 0.7
			});

			if (!L.Browser.ie && !L.Browser.opera) {
				layer.bringToFront();
			}

			info.update(layer.feature.properties);
		}

		var geojson;

		function resetHighlight(e) {
			geojson.resetStyle(e.target);
			info.update();
		}

		function zoomToFeature(e) {
			map.fitBounds(e.target.getBounds());
		}

		function onEachFeature(feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				//click: zoomToFeature //removed movement of map on click
			});
		}
    
$.ajax({
  
  url: '/nepal',
  success: function( data ) {
    
      geojson = L.geoJson(data, {style:style, onEachFeature: onEachFeature}).addTo(map);
  }
});
    
/*
		geojson = L.geoJson(statesData, {
			style: style,
			onEachFeature: onEachFeature
		}).addTo(map);

*/      
        //This is where the Legend comes in
		var legend = L.control({position: 'bottomleft'});
		legend.onAdd = function (map) {
			var div = L.DomUtil.create('div', 'info legend'),
				grades = index_grades,
				labels = [],
				from, to;
			labels.push('<div class="legend-title">Rate</div><div class="legend-wrap">');
			
			for (var i = 0; i < grades.length; i++) {
				from = grades[i];
				to = grades[i + 1];

				labels.push(
					'<i style="background:' + getColor(from + 1) + '"></i> ' +
					from + (to ? '&ndash;' + to : '+'));
			}

			div.innerHTML = labels.join('<br>');

			labels.push('</div>');
			return div;
		};

		legend.addTo(map);
