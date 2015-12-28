var winWidth = $(window).width();

/* drop down */
function DropDown(el) {
  this.dd = el;
  this.placeholder = this.dd.children('span');
  this.opts = this.dd.find('ul.question-dropdown > li');
  this.val = '';
  this.index = -1;
  this.initEvents();
}
DropDown.prototype = {
  initEvents : function() {
    var obj = this;

    obj.dd.on('click', function(event){
      $(this).toggleClass('active');
      return false;
    });

    obj.opts.on('click',function(){
      var opt = $(this);
      obj.val = opt.text();
      obj.index = opt.index();
      obj.placeholder.text(obj.val);
    });
  },
  getValue : function() {
    return this.val;
  },
  getIndex : function() {
    return this.index;
  }
}

$(function() {
  var dd = new DropDown( $('#dd') );

  $(document).click(function() {
    // all dropdowns
    $('.wrapper-dropdown-3').removeClass('active');
  });
});

$(document).ready(function () {
	$('body').show();//show after loading all elements to appear properly
	
	/* High Chart Initialize with setting */
	//For all charts
	Highcharts.setOptions({
    chart: {
      backgroundColor: '#ffffff',
      borderWidth: 0,
      plotBorderWidth: 0,
      plotShadow: true,
      spacingRight: 0,
      style: {
      	fontFamily: 'Roboto, Arial, sans-serif',
      	fontSize: '12px',
      },
    },
    colors: ['#99bc44', '#159c02', '#349de7', '#88d8ef'],
    legend: {
      align: 'left',
      enabled: true,//true, false
      floating: false,
      itemDistance: winWidth,//margin-right to the size of width
      itemMarginBottom: 15,
    },
    plotOptions: {
    	column: {
    		borderWidth: 0,
    		pointPadding: 0,
    		groupPadding: 0.2,
    	}
    },
	});

	//for chart1 only
	var options1 = {
    chart: {
        renderTo: 'container',//#container
        type: 'column'//possible type: bar, column
    },
    title: {
        text: ''//Text if needed
    },
    xAxis: {
        categories: ['January', 'February', 'March'],
    },
    yAxis: {
        title: {
            text: ''//Text if needed
        },
    		gridLineColor: '#e5e5e5',
    },
    series: [{
        name: 'not at all',
        data: [18, 25, 42]
    }, {
        name: 'a little bit',
        data: [50, 50, 50]
    }, {
        name: 'most of them',
        data: [10, 20, 35]
    }, {
        name: 'yes',
        data: [65, 50, 65]
    }]//end series
	};
	var chart1 = new Highcharts.Chart(options1);
});