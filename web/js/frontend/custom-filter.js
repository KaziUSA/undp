$(document).ready(function() {    

    //check all checkboxes
    $("#month-all").change(function(){
      $(".month").prop('checked', $(this).prop("checked"));
    });
    $("#district-all").change(function(){
      $("#form_districts input[type=checkbox]").prop('checked', $(this).prop("checked"));
    });
    $("#gender-all").change(function(){
      $("#form_gender input[type=checkbox]").prop('checked', $(this).prop("checked"));
    });
    $("#ethnicity-all").change(function(){
      $("#form_ethnicities input[type=checkbox]").prop('checked', $(this).prop("checked"));
    });
    $("#age-all").change(function(){
      $("#form_ages input[type=checkbox]").prop('checked', $(this).prop("checked"));
    });

    $('.nav-tabs li.round0').click(function (e) {
        //e.preventDefault();
        //$('.form_months#form_months').html('<li><input class="month" type="checkbox" id="month1_6" value="10" /><label for="month1_6">January<span></span></label></li>');
    });

    $('.nav-tabs li.round1').click(function (e) {
        e.preventDefault();

        $('.form_months#form_months').html('<li><input class="month" type="checkbox" id="month1" value="1" /><label for="month1">January<span></span></label></li><li><input class="month" type="checkbox" id="month2" value="2"/><label for="month2">Feburary<span></span></label></li><li><input class="month" type="checkbox" id="month3" value="3"/><label for="month3">March<span></span></label></li>');
    });

    $('.nav-tabs li.round2').click(function (e) {
        e.preventDefault();

        $('.form_months#form_months').html('<li><input class="month" type="checkbox" id="month4" value="4" /><label for="month4">April<span></span></label></li><li><input class="month" type="checkbox" id="month5" value="5"/><label for="month5">May<span></span></label></li><li><input class="month" type="checkbox" id="month6" value="6"/><label for="month6">June<span></span></label></li>');
    });

    $('.nav-tabs li.round3').click(function (e) {
        e.preventDefault();
        
        $('.form_months#form_months').html('<li><input class="month" type="checkbox" id="month7" value="7" /><label for="month7">July<span></span></label></li><li><input class="month" type="checkbox" id="month8" value="8"/><label for="month8">August<span></span></label></li><li><input class="month" type="checkbox" id="month9" value="9"/><label for="month9">September<span></span></label></li><li><input class="month" type="checkbox" id="month10" value="10" /><label for="month10">October<span></span></label></li><li><input class="month" type="checkbox" id="month11" value="11"/><label for="month11">November<span></span></label></li><li><input class="month" type="checkbox" id="month12" value="12"/><label for="month12">December<span></span></label></li>');
    });

    $('.nav-tabs li.round4').click(function (e) {
        e.preventDefault();
        $('.form_months#form_months').html('<li><input class="month" type="checkbox" id="month1" value="1" /><label for="month1">January<span></span></label></li>');
    });
    $('.nav-tabs li.round5').click(function (e) {
        e.preventDefault();
        $('.form_months#form_months').html('<li><input class="month" type="checkbox" id="month11_5" value="11"/><label for="month11_5">November<span></span></label></li><li><input class="month" type="checkbox" id="month12_5" value="12"/><label for="month12_5">December<span></span></label></li>');
    });
    $('.nav-tabs li.round6').click(function (e) {
        e.preventDefault();
        $('.form_months#form_months').html('<li><input class="month" type="checkbox" id="month1_6" value="10" /><label for="month1_6">January<span></span></label></li>');
    });

    
});