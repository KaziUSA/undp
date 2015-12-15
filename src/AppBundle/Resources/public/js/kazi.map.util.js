// KAZI UTILITIES - LOADING SPINNER
// AUTHOR: Manish Shrestha <manish@kazistudios.com>

KAZI.map.util = (function() {
    //Initialize Private Variables here
    var zoom_level = 6.8;
    var index_grades = [0, 20, 40, 60, 80, 100, 120, 140];//0-10
    var map;
    var legend;
    var geojson;
    var info;
    var theme_color = '#ffffff';
    
    
    //Set all options here
    var options = {
            url:"/nepal"
            
        };
    var style = {
				weight: 1,
				opacity: 1,
				color: '#5d5d5d',
				dashArray: '0',//3
				fillOpacity: 0.7,
				fillColor: '#000'
			};
    
    //Initializing the object
    var init = function(){
        
        
        showMap();
        getMapData();
        showLabel();
    };
    //Public Methods
    var getMapData = function() {
        $.ajax({
            url: '/nepal',
            success: function( data ) {
    
      geojson = L.geoJson(data, {style:style, onEachFeature: onEachFeature}).addTo(map);
        
		
    return;
  }
});   
    }
    
    var showMap = function() {
      map = L.map('map', { 
        zoomControl: true,
        dragging: false,
        }).setView([28.5, 84.3], zoom_level);
      
        L.tileLayer('', {
			maxZoom: 10,
			minZoom: 6.5, //added to remove zoom out
			id: 'kazi-map',
		}).addTo(map);
        map.dragging.enable();
        //This is where the Legend comes in
		legend = L.control({position: 'bottomleft'});
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
        return ;
        
    }
    var showLabel = function() {
        
        // control that shows state info on hover
		info = L.control();

		info.onAdd = function (map) {
			this._div = L.DomUtil.create('div', 'info');
			this.update();
			return this._div;
		};

		info.update = function (props) {
			
			this._div.innerHTML = 
				(props ? '<div class="district-name">' + props.name + '</div><br />' +
				'<div class="girls item"><div class="label"><div class="icon"></div><div class="label-name">Girls</div></div><div class="value">' + props.girls + '%</div></div><div class="clear"></div>'+
				'<div class="boys item"><div class="label"><div class="icon"></div><div class="label-name">Boys</div></div><div class="value">' + props.boys + '%</div></div><div class="clear"></div>'+
				'<div class="total item"><div class="label"><div class="icon"></div><div class="label-name">Total</div></div><div class="value">' + props.total + '%</div></div><div class="clear"></div>' : '<div class="hover-district">Hover over a district</div>');//props.girls, props.boys
		};

		info.addTo(map);
        
        return;
    };
    // get color depending on population density value
		var getColor = function (d) {
			
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

		

		var highlightFeature = function (e) {
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

		var resetHighlight = function (e) {
			geojson.resetStyle(e.target);
			info.update();
		}

		var zoomToFeature = function (e) {
			map.fitBounds(e.target.getBounds());
		}

		var onEachFeature = function (feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				//click: zoomToFeature //removed movement of map on click
			});
		}
    //Getters and Setters
    
    return {
        showLabel: showLabel,
        showMap: showMap,
        init: init
    };
    this.init();
})();
