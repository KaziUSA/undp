
$(document).ready(function(){
//delete - confirmation
  $("#form_submit").click(function(){
    if (!confirm("Are you sure you want to delete?")){
      return false;
    }
  });
});

// to get month, year on changing issueType from Reconstruction, Protection, Livelihood
function ajax_request_response_issueType(dropdown_id, page_path) {
    //create a div aside of dropdown
    $(dropdown_id).parent().append('<span id="appbundle_issueType_details"></span>');

    //on page load - edit page
    ajax_request_response(dropdown_id, page_path);

    $(dropdown_id).change(function() {
        // console.log($(this).val());

        ajax_request_response(dropdown_id, page_path);

      //return false;

    });
}

function ajax_request_response(dropdown_id, page_path) {
    $('#appbundle_issueType_details').html('...');//Loading

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
}

// function for datatables
function getDatatables() {
    $('.dataTables-example').dataTable({
        responsive: true,
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
        }
    });
}




//get url parameter
var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

//get slug 
function slugify(text)
{
  return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}

function get_slug(source, dest) {
    $(source).change(function() {
        var title = $(this).val();
        var slug = slugify(title);
        $(dest).val(slug);
    });
}