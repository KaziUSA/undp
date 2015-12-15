// KAZI UTILITIES - LOADING SPINNER
// AUTHOR: Manish Shrestha <manish@kazistudios.com>
var KAZI = KAZI || {};
KAZI.util = (function(value,percent,gender,total) {
KAZI.util.animate = (function() {
    //Initialize Private Variables here
   // var prev_value =0;
    //Set all options here
    var options = {
            max_height: 40,
            max_width: 100   
        };

    if(value){
    	options.max_height=value.max_height;
    	options.max_width=value.max_width;
    }
    //Initializing the object
    var init = function(p){
        
        catchPercentage(p);
        return p;
    };
   
    var catchPercentage = function(g) {
        //Creating the loading Elements and appending it to the DOM
       animateTo(g);
       //prev_value=g;
       return g;
    }    
    //Getters and Setters
    var animateTo = function(g){
    		var pt=(g*options.max_width)/total;
    	if (gender=="g"){
    		$('.girl').css('height',options.max_height);
    		$('.girl').css('width', pt);
		}else if (gender=="b"){
			$('.boy').css('height',options.max_height);
    		$('.boy').css('width', pt);
		}
    		return g;
		

    }
    init(percent);
    return percent;
    
})();
return percent;
});