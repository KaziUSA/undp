// Select and loop the container element of the elements you want to equalise
// $ = jQuery;
function equal_height(parent_div, child_div) {
  $(parent_div).each(function(){  //'.news-page'
    
    // Cache the highest
    var highestBox = 0;
    
    // Select and loop the elements you want to equalise
    $(child_div, this).each(function(){//'.news-box-module'
      
      // If this box is higher than the cached highest then store it
      if($(this).height() > highestBox) {
        highestBox = $(this).height(); 
      }
    
    });  
          
    // Set the height of all those children to whichever was highest 
    $(child_div,this).height(highestBox);//'.news-box-module'
                  
  }); 
}