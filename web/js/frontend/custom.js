var winWidth = $(window).width();

/* drop down: used in frontend - replaced by plugins/zelect */
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
//end custom dropdown


//change the select value on click
//TODO: add current class in ol > li on clicking next and prev to show selected question in dropdown
function btnPrevQuestion_Click() {
    var selectedIndex = $("#form_questions").prop("selectedIndex");
    if (selectedIndex > 0) {
        $("#form_questions").prop("selectedIndex", selectedIndex - 1);
    }
    //console.log(selectedIndex);
     // class="tlt" data-in-effect="bounceInDown"
     $('.zelected').removeClass('fadeInUp').removeClass('fadeInDown').delay(400)
      .queue(function(next){
        $(this).addClass("fadeInDown");
        $('.zelected').text($('#form_questions option:selected').text());
        next();
      });
}
function btnNextQuestion_Click() {
    //  Note:  the JQuery "prop" function requires JQuery v1.6 or later
    var selectedIndex = $("#form_questions").prop("selectedIndex");
    var itemsInDropDownList = $("#form_questions option").length;

    //  If we're not already selecting the last item in the drop down list, then increment the SelectedIndex
    if (selectedIndex < (itemsInDropDownList - 1)) {
        $("#form_questions").prop("selectedIndex", selectedIndex + 1);
    }
    //console.log(selectedIndex);
    // $('.zelected').removeClass('fadeInDown').removeClass('fadeInUp').addClass('fadeInUp');
    $('.zelected').removeClass('fadeInDown').removeClass('fadeInUp').delay(400)
      .queue(function(next){
        $(this).addClass("fadeInUp");
        $('.zelected').text($('#form_questions option:selected').text());
        next();
      });
}

$(document).ready(function () {
	$('body').show();//show after loading all elements to appear properly

  //custom select
  //$('#zelect select').zelect({ placeholder:'Please select question' });
  $('#zelect select').zelect({ placeholder:'1. Are your main problems being addressed?' });//for default chart


  //TODO: align center horizontally the table data having attribute colspan
  /*if($('.chart-table table th').hasAttr('colspan')) {
    $('.chart-table table th').css({'text-align': 'center'});
  }*/
	
  
	/* High Chart Initialize with setting */

	//For all charts
	Highcharts.setOptions({
      chart: {
        backgroundColor: '#ffffff',
        borderWidth: 0,
        height: 514,
        plotBorderWidth: 0,
        plotShadow: true,
        //renderTo: 'container',//#container: Not needed now
        spacingRight: 0,
        style: {
          fontFamily: 'Roboto, Arial, sans-serif',
          fontSize: '12px',
        },
        type: 'column'//possible type: bar, column
      },
      colors: ['#99bc44', '#159c02', '#349de7', '#88d8ef'],
      legend: {
        align: 'left',
        enabled: true,//true, false
        floating: false,
        itemDistance: winWidth,//margin-right to the size of width
        itemMarginBottom: 15,
        itemStyle: {'fontWeight':'normal'},
        symbolHeight: 15,
        symbolWidth: 15,
        x: 10,//distance of legend from left
        y: 20,
      },
      navigation: {
        buttonOptions: {
          y: 10,
        },
      },
      plotOptions: {
        column: {
          borderWidth: 0,
          pointPadding: 0,
          groupPadding: 0.2,
        }
      },
      title: {
          text: ''//Default: Chart title
      },
      yAxis: {
          title: {
              text: ''//Default: Values
          },
          gridLineColor: '#e5e5e5',
      },
      /*tooltip: {
          formatter: function () {
              return this.point.y + '% says<br>'
                + this.series.name.toLowerCase();
                //+ this.point.name.toLowerCase();
          }
      }*/
	});

	//for chart1 only
	var options1 = {    
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
      }],//end series
      xAxis: {
          categories: ['January', 'February', 'March'],
      },
	};
  $('#container').highcharts(options1);


  //chart from data table
  var options2 = {
      data: {
          table: 'datatable',//#datatable
      },
  };
  $('#container2').highcharts(options2);


  //stacked column chart from data table
  var options3 = {
      chart: {
          type: 'column'
      },
      plotOptions: {
          column: {
              stacking: 'normal',
              dataLabels: {
                  enabled: true,
                  color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                  style: {
                      textShadow: '0 0 3px black'
                  }
              }
          }
      },


      data: {
          table: 'datatable3',//#datatable
      },
  };
  $('#container3').highcharts(options3);
});