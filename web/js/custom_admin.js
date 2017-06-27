
$(document).ready(function(){
//delete - confirmation
  $("#form_submit").click(function(){
    if (!confirm("Are you sure you want to delete?")){
      return false;
    }
  });
});

// to get month, year on changing issueType from Reconstruction, Protection, Livelihood
function ajax_request_response_issueType(dropdown_id, page_path, output_div_id) {
    //create a div aside of dropdown
    $(dropdown_id).parent().append('<span id="appbundle_issueType_details"></span>');

    $(dropdown_id).change(function() {
        // console.log($(this).val());
        $('#appbundle_issueType_details').html('Loading...');

        var name = { 
                    id: $(dropdown_id).val(),
                    };//{{ entity.id }}
    
        $.post(page_path,//path: /admin/page/home
            { 
                data_id: name.id 
            }, 
            function (response) { 
                // console.log("Request Sent");

                var responseJSON = $.parseJSON(response);           

                if(responseJSON.code == 100 && responseJSON.success){//dummy check
                    result = responseJSON.result;

                    if(result) {
                        // $(output_div_id).html('<strong>Selected issue type:</strong> ' + responseJSON.result);
                        $('#appbundle_issueType_details').html(responseJSON.result);
                        
                        /*result.forEach(function(object) {
                        console.log(object);                
                       });*/

                    }
                }
            }
        );

      //return false;

    });
}