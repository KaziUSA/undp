// KAZI UTILITIES - LOADING SPINNER
// AUTHOR: Manish Shrestha <manish@kazistudios.com>

KAZI.util.loading = (function() {
    //Initialize Private Variables here
    var mainDiv = "";
    
    //Set all options here
    var options = {
            id:"loading"
            
        };
    
    //Initializing the object
    var init = function(){
        
        createDivs();
    };
    //Public Methods
    var show = function() {
        // Turn on loading
        $(mainDiv).show();
        
        return mainDiv;
    };
    var hide = function() {
        $(mainDiv).hide();
        return mainDiv;
        
    };
    var createDivs = function() {
        //Creating the loading Elements and appending it to the DOM
        d= document.createElement('div');
        $(d).addClass('sk-spinner');
        $(d).addClass('sk-spinner-cube-grid');
        
        for(i=0;i<9;i++){
            s = document.createElement('div');
            $(s).addClass('sk-cube');
            $(d).append($(s));
        }
        
        spinner = document.createElement('div');
        $(spinner).addClass('spinner');
        $(spinner).append($(d));
        
        
        $(spinner).center();
        $(spinner).css('z-index', 2041);
        
        
        bkdrop = document.createElement('div');
        
        //Adding all the CSS Info
        $(bkdrop).addClass('backdrop');
        $(bkdrop).addClass('in');
        $(bkdrop).css('z-index', 2040);
        $(bkdrop).css('position', 'fixed');
        $(bkdrop).css('top', 0);
        $(bkdrop).css('right', 0);
        $(bkdrop).css('bottom', 0);
        $(bkdrop).css('left', 0);
        $(bkdrop).css('background-color', '#000');
        $(bkdrop).css('opacity', '0.5');
        
        
        mainDiv = document.createElement('div');
        mainDiv.setAttribute('id', options.id);
        
        $(mainDiv).append($(spinner));
        $(mainDiv).append($(bkdrop));
        
        $('body').append($(mainDiv));
        
        $('#' + options.id).hide();
    }    
    //Getters and Setters
    
    return {
        show: show,
        hide: hide,
        init: init
    };
    this.init();
})();

