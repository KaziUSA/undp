// Select and loop the container element of the elements you want to equalise
// $ = jQuery;

$('window').load(function() {
  //show after complete load
  // $('body').show();
});

$(document).ready(function() {
  //zelect on click - platform
  $('.zelect li').click(function() { 
    $('.zelect li').removeClass('current'); 
    $(this).addClass('current'); 
  });

  $('body').addClass('full-opacity');

  //global equal height
  equal_height('.parent-height', '.child-height');
});

$(window).resize(function() {  
  //global equal height
  equal_height('.parent-height', '.child-height');
});

//to make equal height
function equal_height(parent_div, child_div) {
  //first make their height auto
  $(child_div).css({'height': 'auto'});
  

  var win_width = $(window).width();

  if(win_width >= 768) {
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
}

//jplayer for audio
function jquery_jplayer(player_id, audio_name, audio_path) {
  $("#jquery_jplayer_"+player_id).jPlayer({
    ready: function () {
      $(this).jPlayer("setMedia", {
        title: audio_name,
        // m4a: "http://www.jplayer.org/audio/m4a/Miaow-08-Stirring-of-a-fool.m4a",
        // oga: "http://www.jplayer.org/audio/ogg/Miaow-08-Stirring-of-a-fool.ogg"
        mp3: "/uploads/issue/news/audio/" + audio_path
      });
    },
    // swfPath: "../../dist/jplayer",
    swfPath: "/js/plugins/jplayer",
    // supplied: "m4a, oga",
    supplied: "mp3",
    // cssSelectorAncestor: "", //not needed for 1
    wmode: "window",
    globalVolume: true,
    useStateClassSkin: true,
    autoBlur: false,
    smoothPlayBar: true,
    keyEnabled: true
  });
}

function jquery_jplayer_other(player_id, audio_name, audio_path) {
  $("#jquery_jplayer_"+player_id).jPlayer({
    ready: function () {
      $(this).jPlayer("setMedia", {
        title: audio_name,
        // m4a: "http://www.jplayer.org/audio/m4a/Miaow-02-Hidden.m4a",
        // oga: "http://www.jplayer.org/audio/ogg/Miaow-02-Hidden.ogg"
        mp3: "/uploads/issue/news/audio/" + audio_path
      });
    },
    // swfPath: "../../dist/jplayer",
    swfPath: "/js/plugins/jplayer",
    // supplied: "m4a, oga",
    supplied: "mp3",
    cssSelectorAncestor: "#jp_container_"+player_id,//player id again
    wmode: "window",
    globalVolume: true,
    useStateClassSkin: true,
    autoBlur: false,
    smoothPlayBar: true,
    keyEnabled: true
  });
}
