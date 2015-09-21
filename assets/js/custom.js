var pleaseWaitDiv = $('<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-header"><h4>Please wait...</h4></div><div class="modal-body"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div></div>');



$('#add-evidence_all').click(function(){

  $('#divadd-evidence_all').show();
  $('#add-evidence-minus_all').show();
  $('#add-evidence_all').hide();


});

$('#add-testimonial_all').click(function(){

  $('#add-testimonial-minus_all').show();
  $('#add-testimonial_all').hide();

  $('#divadd-testimonial_all').show();
});



$('#add-evidence-minus_all').click(function(){

  $('#divadd-evidence_all').hide();

});

$('#add-testimonial-minus_all').click(function(){

  $('#divadd-testimonial_all').hide();
});



$('#select_lista').hide();
$('#recipient-message').hide();
$('#uplod-csv').hide();
$('#error-div').hide();
 // $('#add-evidence-minus').hide();
 // $('#add-testimonial-minus').hide();

 // $('#image_arrow').show();

 $('#select_type').change(function(){
  var val= $('#select_type').val();

  if (val == "Mailchimp"){
    $('#type_name').show();
    $('#select_lista').hide();
    $('#uplod-csv').hide();
    $('#image_arrow').show();
    $('#divnewcredlycontactlist').hide();
    $('#divnewmailchimpcontactlist').show();
    $('#divaddonefive').hide();
  }
  else if (val == "Credly"){
    $('#type_name').hide();
    $('#uplod-csv').hide();
    $('#select_lista').show();
    $('#image_arrow').show();
    $('#divnewcredlycontactlist').show();
    $('#divnewmailchimpcontactlist').hide();
    $('#divaddonefive').hide();
    $('#divaddonefive').hide();

  }
  else if (val == "Manually"){
    $('#type_name').hide();
    $('#first_receipient').show();
    $('#uplod-csv').hide();
    $('#select_lista').hide();
    $('#image_arrow').hide();
    $('#divnewcredlycontactlist').hide();
    $('#divnewmailchimpcontactlist').hide();
    $('#divaddonefive').show();

  }
  else if (val == "CSV"){
    $('#type_name').hide();
    $('#select_lista').hide();
    $('#image_arrow').hide();
    $('#uplod-csv').show();
    $('#divnewcredlycontactlist').hide();
    $('#divnewmailchimpcontactlist').hide();
    $('#divaddonefive').hide();
  }
});


var val= $('#select_type').val();

if (val == "Mailchimp"){
  $('#type_name').show();
  $('#select_lista').hide();
  $('#uplod-csv').hide();
  $('#image_arrow').show();
  $('#divnewcredlycontactlist').hide();
  $('#divnewmailchimpcontactlist').show();
  $('#divaddonefive').hide();
}
else if (val == "Credly"){
  $('#type_name').hide();
  $('#uplod-csv').hide();
  $('#select_lista').show();
  $('#image_arrow').show();
  $('#divnewcredlycontactlist').show();
  $('#divnewmailchimpcontactlist').hide();
  $('#divaddonefive').hide();

}
else if (val == "Manually"){
  $('#type_name').hide();
  $('#first_receipient').show();
  $('#uplod-csv').hide();
  $('#select_lista').hide();
  $('#image_arrow').hide();
  $('#divnewcredlycontactlist').hide();
  $('#divnewmailchimpcontactlist').hide();
  $('#divaddonefive').show();
}
else if (val == "CSV"){
  $('#type_name').hide();
  $('#select_lista').hide();
  $('#image_arrow').hide();
  $('#uplod-csv').show();
  $('#divnewcredlycontactlist').hide();
  $('#divnewmailchimpcontactlist').hide();
  $('#divaddonefive').hide();
}



$('#frm_MC').submit(function(event) {
  event.preventDefault();
  var $form = $( this ),
  key = $form.find( 'input[name="key"]' ).val();
  list = $form.find( 'select[name="list"]' ).val();
  
  url = $form.attr( 'action' );
  if(key == ''){
    alert('No API key');
  }else if(list == 0){
    alert('Select a list');
  }else{
    $form.find( ':submit' ).text('Please wait...');
    $form.find( ':submit' ).attr('disabled', 'disabled');
    $.ajax({
      type: "POST",
      url: url,
      async: true,
      data: {key : key , list :list},
      dataType: 'json',
      success: function(data) {
        //alert('Request is processed!');
        if(data == true){
          location = '';
        }else if(data == false){
          alert('Incorrect API');
        }

        $form.find( ':submit' ).text('Submit');
        $form.find( ':submit' ).removeAttr('disabled', 'disabled');
        
      }
    });
  }
  return false;
});
$('#frm_MD').submit(function(event) {
  event.preventDefault();
  var $form = $( this ),
  key = $form.find( 'input[name="key"]' ).val();
  list = $form.find( 'select[name="list"]' ).val();
  
  url = $form.attr( 'action' );
  if(key == ''){
    alert('No API key');
  }else if(list == 0){
    alert('Select a list');
  }else{
    $form.find( ':submit' ).text('Please wait...');
    $form.find( ':submit' ).attr('disabled', 'disabled');
    $.ajax({
      type: "POST",
      url: url,
      async: true,
      data: {key : key , list :list},
      dataType: 'json',
      success: function(data) {
       if(data == true){
        location = '';
        //alert('Request is processed!');
      }else if(data == false){
        alert('Incorrect API');
      }
      $form.find( ':submit' ).text('Submit');
      $form.find( ':submit' ).removeAttr('disabled', 'disabled');

      
    }
  });
  }
  return false;
});


// $('#changeMC').click(function(){
//   $('.MCkeyform').show();
// });
// $('#closeMcFrm').click(function(){
//   $('.MCkeyform').hide();
// });
// $('#changeMD').click(function(){
//   $('.MDkeyform').show();
// });
// $('#closeMdFrm').click(function(){
//   $('.MDkeyform').hide();
// });


// Get mailchimp list

$('#get_list').click(function(){
  var key = $('#key').val();

  if(!key){
    alert('Enter a key first');
  }else{
    var options = $("#MClists");
    options.empty();
    $('#loading-image').show();
    $.ajax({
      url: "common/settings/getList",
      type: "post",
      data: { key: key},
      datatype: "json",
      success: function(response){
        if(response == 0){
          alert("No lists Found or Incorrect API Key");
        }else{
          for(var i = 0; i < response.length; ++i)
          {
            $.each(response[i], function(id, name){
              options.append("<option value='"+ id +"'>"+ name +"</option>");
            });
          }
        }
      },
      complete: function(){ 
       $('#loading-image').hide();
     }
   });
  }

});


$('#btnstep1, #preview_editres, #btnstep3back').click(function(e){

 if($('input:radio[name="optionsRadiosBadge"]').is(':checked')) 
 { 
  $('#divstep1').hide();
  $('#divstep3').hide();
  $('#divstep4').hide();
  $('#divstep2').show();

  $('#bar').css('width', 20+'%');

}
else 
{

  alert("You must select a Credly badge before you continue to the next step."); 
}

});


$('#btnstep2back, #preview_editbadge').click(function(e){
  $('#divstep1').show();
  $('#divstep2').hide();
  $('#divstep3').hide();
  $('#divstep4').hide();
  $('#bar').css('width', 2+'%');

});

$('#btnstep2,#btnstep4back, #preview_editevidence, #preview_edittestimonial, #preview_editincludeemail').click(function(e){
  var array = [];
   var x = 0;
   //var data='';

  // //alert('test');
  $('.form-inline.contect-form').each(function(){

    dataString = $('#divstep3').serialize();
    array[x]=dataString;
    x = x + 1;
    //alert(dataString);
  });
  if(x > 0)
  {
     if(!$('#email').val())
   {

    alert('Please enter a valid email id');
    return;
   }
  $('#divstep3').show();
  $('#divstep1').hide();
  $('#divstep4').hide();
  $('#divstep2').hide();
  $('#bar').css('width', 45+'%');
  }
  else
  {
    alert('Please add atleast one raecipient');
  }
  
  // validate email id
   



  

});




$("input[name=optionsRadiosBadge]").click(function(e){

  $('#imgcredlybadge').attr("src", $(this).attr("src"));
  $('#imgcredlybadge').attr("badgeid",$(this).attr("value") );
  $('#imgcredlybadge').attr("alt",$(this).attr("alt") );

  $('#imgcredlybadge_preview').attr("src", $(this).attr("src"));
  $('#titlecredlybadge_preview').text($(this).attr("alt"));

  $('#imgcredlybadge_preview_congrats').attr("src", $(this).attr("src"));
  $('#titlecredlybadge_preview_congrats').text($(this).attr("alt"));


});


$('#chkincludeemailnotifications').change(function(e){
  if ($('#chkincludeemailnotifications').is(':checked')){
    $('#divincludeemailnotifications').show();
  }
  else 
  {
    $('#divincludeemailnotifications').hide();
  }
});


$('#chkincludecustommessage').change(function(e){

  if ($('#chkincludecustommessage').is(':checked')){
    $('#divincludecustommessage').show();
  }
  else 
  {
    $('#divincludecustommessage').hide();
  }
});


$('#add-evidence_all').click(function(){

  $('#divadd-evidence_all').show();
  $('#add-evidence-minus_all').show();
  $('#add-evidence_all').hide();


});

$('#add-testimonial_all').click(function(){

  $('#add-testimonial-minus_all').show();
  $('#add-testimonial_all').hide();
  $('#divadd-testimonial_all').show();
});


$('#select_templateone').change(function(){


  var val= $('#select_templateone').val();

  if (val == "false"){
   $('#select_template_twodefault').show();
   $('#select_template_twodefault_custommessage').hide();
 }
 else 
 {
  $('#select_template_twodefault').hide();
  $('#select_template_twodefault_custommessage').show();
}

});

$('#add-evidence-minus_all').click(function(){


  $('#add-evidence-minus_all').hide();
  $('#add-evidence_all').show();
  $('#divadd-evidence_all').hide();

});

$('#add-testimonial-minus_all').click(function(){


  $('#add-testimonial-minus_all').hide();
  $('#add-testimonial_all').show();
  $('#divadd-testimonial_all').hide();
});



$('#select_lista').hide();
$('#recipient-message').hide();
$('#uplod-csv').hide();
$('#error-div').hide();
 // $('#add-evidence-minus').hide();
 // $('#add-testimonial-minus').hide();

 // $('#image_arrow').show();

 $('#select_type').change(function(){
  var val= $('#select_type').val();

  if (val == "Mailchimp"){
    $('#type_name').show();
    $('#select_lista').hide();
    $('#uplod-csv').hide();
    $('#image_arrow').show();
    $('#select_list_step5').removeAttr("disabled");
    $('#savetocredlylist').removeAttr("disabled");

  }
  else if (val == "Credly"){
    $('#type_name').hide();
    $('#uplod-csv').hide();
    $('#select_lista').show();
    $('#image_arrow').show();
    $('#select_list_step5').attr("disabled", "disabled");
    $('#savetocredlylist').attr("disabled", "disabled");

  }
  else if (val == "Manually"){
    $('#type_name').hide();
    $('#first_receipient').show();
    $('#uplod-csv').hide();
    $('#select_lista').hide();
    $('#image_arrow').hide();
    $('#select_list_step5').removeAttr("disabled");
    $('#savetocredlylist').removeAttr("disabled");

  }
  else if (val == "CSV"){
    $('#type_name').hide();
    $('#select_lista').hide();
    $('#image_arrow').hide();
    $('#uplod-csv').show();
    $('#select_list_step5').removeAttr("disabled");
    $('#savetocredlylist').removeAttr("disabled");
  }

});


var val= $('#select_type').val();

if (val == "Mailchimp"){
  $('#type_name').show();
  $('#select_lista').hide();
  $('#uplod-csv').hide();
  $('#image_arrow').show();
  $('#select_list_step5').removeAttr("disabled");
  $('#savetocredlylist').removeAttr("disabled");
}
else if (val == "Credly"){
  $('#type_name').hide();
  $('#uplod-csv').hide();
  $('#select_lista').show();
  $('#image_arrow').show();
  $('#select_list_step5').attr("disabled", "disabled");
  $('#savetocredlylist').attr("disabled", "disabled");


}
else if (val == "Manually"){
  $('#type_name').hide();
  $('#first_receipient').show();
  $('#uplod-csv').hide();
  $('#select_lista').hide();
  $('#image_arrow').hide();
  $('#select_list_step5').removeAttr("disabled");
  $('#savetocredlylist').removeAttr("disabled");

}
else if (val == "CSV"){
  $('#type_name').hide();
  $('#select_lista').hide();
  $('#image_arrow').hide();
  $('#uplod-csv').show();
  $('#select_list_step5').removeAttr("disabled");
  $('#savetocredlylist').removeAttr("disabled");
}



$('#frm_MC').submit(function(event) {
	event.preventDefault();
	var $form = $( this ),
  key = $form.find( 'input[name="key"]' ).val();
  list = $form.find( 'select[name="list"]' ).val();
  
  url = $form.attr( 'action' );
  if(key == ''){
  	alert('No API key');
  }else if(list == 0){
  	alert('Select a list');
  }else{
    $form.find( ':submit' ).text('Please wait...');
    $form.find( ':submit' ).attr('disabled', 'disabled');
    $.ajax({
      type: "POST",
      url: url,
      async: true,
      data: {key : key , list :list},
      dataType: 'json',
      success: function(data) {
       if(data == true){
        location = '';
        // alert('Request is processed!');
      }else if(data == false){
        alert('Incorrect API');
      }
      $form.find( ':submit' ).text('Submit');
      $form.find( ':submit' ).removeAttr('disabled', 'disabled');

    }
  });
  }
  return false;
});


$('#frm_MD').submit(function(event) {
  event.preventDefault();
  var $form = $( this ),
  key = $form.find( 'input[name="key"]' ).val();
  list = $form.find( 'select[name="list"]' ).val();
  
  url = $form.attr( 'action' );
  if(key == ''){
    alert('No API key');
  }else if(list == 0){
    alert('Select a list');
  }else{
    $form.find( ':submit' ).text('Please wait...');
    $form.find( ':submit' ).attr('disabled', 'disabled');
    $.ajax({
      type: "POST",
      url: url,
      async: true,
      data: {key : key , list :list},
      dataType: 'json',
      success: function(data) {
        if(data == true){
          location = '';
          // alert('Request is processed!');

        }else if(data == false){

          alert('Incorrect API');
        }
        $form.find( ':submit' ).text('Submit');
        $form.find( ':submit' ).removeAttr('disabled', 'disabled');


      }
    });
  }
  return false;
});
$('#changeMC').click(function(){
	$('.MCkeyform').show();
});
$('#closeMcFrm').click(function(){
	$('.MCkeyform').hide();
});
$('#changeMD').click(function(){
  $('.MDkeyform').show();
});
$('#closeMdFrm').click(function(){
  $('.MDkeyform').hide();
});

// Get mailchimp list

$('#get_list').click(function(){
  var key = $('#key').val();

  if(!key){
    alert('Enter a key first');
  }else{
    var options = $("#MClists");
    options.empty();
    $('#loading-image').show();
    $.ajax({
      url: "common/settings/getList",
      type: "post",
      data: { key: key},
      datatype: "json",
      success: function(response){
        if(response == 0){
          alert("No lists Found or Incorrect API Key");
        }else{
          for(var i = 0; i < response.length; ++i)
          {
            $.each(response[i], function(id, name){
              options.append("<option value='"+ id +"'>"+ name +"</option>");
            });
          }
        }
      },
      complete: function(){	
       $('#loading-image').hide();
     }
   });
  }

});
