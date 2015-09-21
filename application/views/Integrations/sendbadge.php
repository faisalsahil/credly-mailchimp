<div class="row-fluid" style="float:left;min-width:1250px;" >
  <div class="hero-unit">
    <div class="well" style="font-size:12px;">

      <ul class="breadcrumb" style="font-size:12px;">
        <li><a href="#">Issue Badges</a> <span class="divider">/</span></li>
        <li class="active">Send Badge Now</li>
      </ul>

      <h3>Send Badge Now</h3>
      <img id="imgcredlybadge" class="pull-left" src="https://credly.com/addons/shared_addons/themes/credly/img/blank-badge-image.png" badgeid="0" width="100" height="100" alt="Credly Badge" border="0" style="display:block;margin-right:3em;" />


      <br/>
      <table>
        <tbody>
          <tr>
            <td><strong>1. Select badge </strong></td>
            <td><span style="margin-left:14em;"></span><strong>2. Choose recipients</strong></td>
            <td><span style="margin-left:14em;"></span><strong>3. Set delivery options</strong></td>
            <td><span style="margin-left:14em;"></span><strong>4. Send</strong></td>
          </tr>
        </tbody>
      </table>

      <div class="progress progress-success">

        <div id="bar" class="bar" style="width: 2%"></div>
      </div>
      <br/>


      <!--  ------------------------------      STEP 1    --------------------------------------  -->
      <div id="divstep1"  >
        Issue a badge now to a MailChimp List or Credly Contact List, or to a CSV file of recipients. <br/>
        You can even use a Credly-enabled MailChimp <a href="<?php echo base_url();?>template">email template</a>.


        <br/><br/><strong>1. Which badge would you like to issue?</strong><br /><br />
        Need a new Credly badge? <a target="_blank" href="https://credly.com/badge-builder">Create one now.</a> <br/><br/>

        <?php include('application/views/Integrations/select_badge_form.php') ?>

        <button id="btnstep1" class="btn btn-success pull-right">Next</button>
      </div>


      <!--  ------------------------------      STEP 2    --------------------------------------  -->
      <div id="divstep2" style="display:none;">
      <!-- <div id="divstep2"> -->

        <strong>2. To whom would you like to issue this badge ?</strong><br/><br/>
        <!-- /////////////////////////////////  select type dropdown /////////////////////////////// -->
        <div class="alert alert-info">

          <input id="templatehtmlasved" type="hidden"/>
          <select style="font-size:12px;" name="select_type" id="select_type" class="dropdown">

            <option value="Manually" select= "selected">Add Recipients Manually</option>
            <option value="Mailchimp" >Use a MailChimp List</option>
            <option value="Credly">Use a Credly Contact List</option>
            <option value="CSV">Upload CSV File</option>

          </select>

          <img id="image_arrow" width="32" height="18" alt="Arrow" src="https://staging.credly.com/addons/shared_addons/themes/credly/img/blue-bg-arrow.png" />
          <!-- <input type="text" name="type_name" id="type_name" placeholder="Type Name"/> -->

          <select style="font-size:12px;" name="type_name" id="type_name">
            <option value="0" selected="selected">Select a List</option>
            <?php foreach ($lists as $list) { ?>
            <option value="<?php echo $list['id']; ?>" ><?php echo $list['name']."   ( ". $list['stats']['member_count'] ." )"; ?></option>
            <?php } ?>
          </select>

          <select style="font-size:12px;" name="select_lista" id="select_lista" required>
            <option value="0" selected="selected">Select a List</option>
            <?php foreach ($credly_lists as $list1) { ?>
            <option value="<?php echo $list1->id; ?>" ><?php echo $list1->name."   ( ". $list1->total_contacts ." )";?></option>
            <?php } ?>
          </select>
          <div id="uplod-csv">
            (?) How should my CSV file be formatted? <br/>
            Your CSV should have three columns, and *no* header row.<br/>
            The order of the columns should be first name, last name, email address. <br/>

            <br/>

            <form enctype="multipart/form-data" action="<?php echo base_url();?>Integrations/sendbadge/upload_csv" method="POST" id="csv-form-submit">
              <input type="file" class="csv-file"  name="csv-file" id="csv-file"/>
              <input type="submit" class="btn btn-primary" name="upload-csv-file" id="upload-csv-file" value="Submit"/><br/>
            </form>

            For example:<br/>
            John, Doe, john@test.com<br/>
            Mary, Smith, mary@test.com

            <!-- The CSV could not be imported due to an error with the format. Please check the format and try again. -->
          </div>

          <label id="labelnumberofrecipients" class="pull-right" style="display:none;"></label>

        </div>
        <div id="divnewcredlycontactlist" style="display:none;">
          Need a new Credly Contact list? <a target="_blank" href="https://credly.com/my-contacts/">Create one now</a><br />
        </div>
        <div id="divnewmailchimpcontactlist" style="display:none;">
          Need a new MailChimp list? <a target="_blank"  href="https://us6.admin.mailchimp.com/lists/">Create one now</a><br/>
        </div>


        <!-- <div id="sendbadge-form"  style="display:none;"> -->
        <div id="sendbadge-form" >

        </div>
        <!-- //////////////////////////////   adding more forms div /////////////////////////////// -->
        <div id="divaddonefive" style="display:none;">
          <ul>
            <a href="javascript:void(0);" id="add-recipient" class="add-recipient" style="color:red">Add recipient</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="javascript:void(0);" id="add-recipient-five" style="color:red">Add 5 at a time</a></li>
          </ul>
        </div>
        <div class="pull-right">
          <button id="btnstep2back" class="btn btn-primary">Back</button>
          <button id="btnstep2" class="btn btn-success">Next</button>
        </div>

      </div>

      <!--  ------------------------------      STEP 3    -------------------------------------- -->

      <div id="divstep3" style="display:none;">

        <strong></strong><br/><br/>

        <strong><label style="font-size:12px;" class="pull-left"> To what MailChimp list would you like to<br/> save the recipients of this campaign?</lebel></strong>
        <select style="font-size:12px;margin-left:20px;" name="select_list1" id="select_list1" required>
          <option value="0" selected="selected">Select a MailChimp List</option>
          <?php foreach ($lists as $list) { ?>
          <option value="<?php echo $list['id']; ?>" ><?php echo $list['name']; ?></option>
          <!-- <option value="0" selected="selected">Select a List</option> -->
          <?php } ?>
        </select><br/><br/>


        <!-- Would you like to notify recipients by email?</strong> <br/><br/>
        <input id="chkincludeemailnotifications" type="checkbox" checked />
        Yes, send email notification (recommended)
        <br/> -->
        <div id="divincludeemailnotifications" class="well">

          <strong><label style="font-size:12px;"> Select your pre-customized Template :</lebel></strong>

          <div id="select_template_default"  class="pull-left">
            <select style="font-size:12px;" name="select_templateone" id="select_templateone" style="min-width:350px;right-margin:5px;">
              <option value="true">Send default Credly notification email</option>
              <option value="false">Use one of my MailChimp email templates</option>
            </select>
          </div>
          


          <div id="select_template_twodefault" style="display:none">
            <span style="margin-left:20px;"></span>
            <select style="font-size:12px;" name="select_template_two" id="select_template_two" >
              <option value="0" selected="selected" >Select a Template</option>
              <?php foreach($templates as $template) { ?>
              <option value="<?php echo $template->id ?>" ><?php echo $template->templatename; ?></option>
              <?php } ?>
            </select>
            <span style="margin-left:20px;"></span>
            <!-- <strong><a id ="myModalb" href="#myModalhtml" role="button" data-toggle="modal">Preview</a></strong> -->
            <strong><a id="myModalb">Preview</a></strong>

            <div id="question_mark_sendbadge">
              <img class="icon-question-sign">
              Don't see the Mailchimp template you are looking for ? Visit the "Email Template" area to Credly-enable it. 
            </div>
            <br/><br/>

            <strong>When would you like to send your MailChimp badge email Campaign ?</strong> <br/><br/>
            <select style="font-size:12px;margin-right:20px;" name="select_timeoption" id="select_timeoption" class="pull-left">
              <option value="0" selected="selected" >Send Immediately</option>
              <option value="1" >At a future scheduled time</option>
            </select>
            <!-- <input type="text" date-date-format="2013-10-01" name="datepicker" id="datepicker" data-date-format="yyyy-mm-dd"  data-date="2013-01-01"  value="<?php //echo Date('Y-m-d'); ?>">-->
            <!-- <input type="text" date-date-format="2013-10-01" name="datepicker" id="datepicker" data-date-format="yyyy-mm-dd"  data-date="2013-01-01"  value="<?php echo Date('Y-m-d'); ?>">-->
            <!-- <span style="margin-left:20px;"></span> -->
            <div id="datetimepicker2" class="input-append" style="display:none;">
              <input data-format="MM/dd/yyyy HH:mm:ss PP" type="text"  id="datepicker" />
              <span class="add-on">
              <i data-time-icon="icon-time" data-date-icon="icon-calendar">
              </i><a href="http://www.timeanddate.com/worldclock/city.html?n=179"> USA/Eastern Time</a>  

            </div>
            <!-- Enter the send time in <a href="http://www.timeanddate.com/worldclock/city.html?n=179"> USA/Eastern Time</a> (NYC Time) -->

            <br/>
            <br/>

          </div>


          <div class= "float-left" id="select_template_twodefault_custommessage">
            <span style="margin-left:5px;"></span>
            <input class= "float-left"  id="chkincludecustommessage" type="checkbox" />
            Include custom message? (This appears in the email notification to badge recipients.)<br/>
            <div class= "float-left" id="divincludecustommessage" style="display:none;">
              <br/>
              <textarea name="txtincludecustommessage" id="txtincludecustommessage" class="testimonial-area" maxlength="2000" placeholder="Include custom message here"  style="width:700px; height:80px;">
              </textarea><br/>
            </div>

          </div>
        </div>
        <br/>

        <!-- <span id="add-evidence_all" class="icon-plus-sign evidence-plus"></span>
        <span id="add-evidence-minus_all" class="icon-minus-sign evidence-minus"  style="display:none;"></span> -->

        <!-- <div id="divadd-evidence_all" style="display:none;"> -->
        <div id="divadd-evidence_all" id="evidence" style="float:left;width:50%;">
          <strong> Include Evidence (optional)</strong> <br/><br/>
          The link or file you attach will be included with every badge issued as evidence of the recipient's achievement. <br/>

          <form enctype="multipart/form-data" action="<?php echo base_url();?>Integrations/sendbadge/upload_doc" method="POST" id="doc-form-submit">
            <label style="font-size:12px;" >Enter a URL:</label>
            <input id="gevidence" type="text" value="" placeholder="http://" />
            <input type="hidden" id="fileevidence" type="text" value="" />
            <div>
              - or -     
              <input type="file" class="doc-file"  name="doc-file" id="doc-file" value="http://" /> 
            </div>
            <input type="submit" class="btn btn-primary btn-mini" name="upload-doc-file" id="upload-doc-file" value="Submit" />
          </form>

        </div>

        
        <div id="vertical_line"></div>
        <!-- 
        <span id="add-testimonial_all" class="icon-plus-sign testimonial-plus"></span>
        <span id="add-testimonial-minus_all" class="icon-minus-sign testimonial-minus" style="display:none;"></span> -->
        
        <!-- <div id="divadd-testimonial_all" style="display:none;"> 
      -->
      <div id="divadd-testimonial_all" id="testimonial" >
        <strong>Include Testimonial (optional) </strong><br/><br/>
        The testimonial you include here will be included with every badge.<br/> Tell the world why this person deserves this badge. <br/>(Tip: Avoid using names or pronouns, since you may not know in advance specifically who will earn this badge.)<br/>
        <textarea name="testimonial-area" id="testimonial-area" class="testimonial-area" maxlength="2000" placeholder="Write testimonial here" style="width:330px; height:80px;"></textarea><br/>
      </div>


      <br/>
      <div class="pull-right">
        <button id="btnstep3back" class="btn btn-primary">Back</button>
        <button id="btnstep3" class="btn btn-success">Next</button>
      </div>

    </div>

    <div id="popup-parent-div">
    </div>



    <!--  ------------------------------      STEP 4    --------------------------------------  -->
    <div id="divstep4" style="display:none;">
      <strong></strong><br/><br/>

      <table class="table"> 
        <tbody>
          <tr>
            <td><strong>You are about to send the badge: </strong></td>
            <td><label id="titlecredlybadge_preview" ></label><img id="imgcredlybadge_preview" src="https://credly.com/addons/shared_addons/themes/credly/img/blank-badge-image.png" width="50" height="50" alt="Credly Badge" border="0" style="display:block">
            </td>
            <td><a id='preview_editbadge'>Edit</a></td>
          </tr>
          <tr>
            <td><strong>Recipients: </strong></td>
            <td></td>
            <td><a id='preview_editres' >Edit</a></td>
          </tr>
          <tr>
            <td><strong>Evidence: </strong></td>
            <td><label id="previewevidence" ></label></td>
            <td><a id='preview_editevidence' >Edit</a></td>
          </tr>
          <tr>
            <td><strong>Testimonial: </strong></td>
            <td> <textarea name="previewtestimonial-area" id="previewtestimonial-area" style="width:200px; height:80px;"></textarea></td>
            <td><a id='preview_edittestimonial' >Edit</a></td>
          </tr>

          <tr>
            <td><strong>Include notification email: </strong></td>
            <td><label id="previewincludeemailnotifications" ></label></td>
            <td><a id='preview_editincludeemail' >Edit</a></td>
          </tr>
          <tr>
            <td><strong>Email template: </strong></td>
            <td><label id="previewselect_template_two" ></label></td>
            <td><a id='preview_editemailtemp'  href="<?php echo base_url('template'); ?>">Edit</a></td>
            <td>
             <a id='preview_myModalb'>Preview</a>
           </td>
         </tr>
       </tbody>
     </table>


     <strong>If everything looks great, click the "Issue Badge" button to send your badge now: </strong><br/>

     <div class="pull-right">
      <button id="btnstep4back" class="btn btn-primary">Back</button>
      <button id="btnstep4" class="btn btn-success" data-loading-text="Loading..." >Issue badge</button>
    </div>
  </div>


  <!--  ------------------------------    END  STEP 4    --------------------------------------  -->

  <!--  ------------------------------      STEP 5   --------------------------------------  -->

  <div id="divstep5" style="text-align:center;display:inline-block;display:none;">
    <!-- <div id="divstep5" style="text-align:center;display:inline-block;"> -->
    <strong style="Color:green">Congratulations!</strong><br/><br/>
    Your badge has be queued for delivery.<br/> It may take few minutes to reach recipients. <br/><br/>

    <img id="imgcredlybadge_preview_congrats" src="https://credly.com/addons/shared_addons/themes/credly/img/blank-badge-image.png" width="100" height="100" alt="Credly Badge" border="0" />
    <strong><label id="titlecredlybadge_preview_congrats" ></label></strong><br/>
    Save recipients to credly contact list for future use <br/>
    <div id="step5finalmessage" >
      <div>
        <select style="font-size:12px;" name="select_list_step5" id="select_list_step5" required >
          <option value="0" selected="selected">Select a List</option>
          <?php foreach ($credly_lists as $list1) { ?>
          <option value="<?php echo $list1->id; ?>" ><?php echo $list1->name; ?></option>
          <?php } ?>
          <option value="newlist"> Create new list ...</option>
        </select>
        <br/>
        <input type="submit" class="btn btn-success btn-mini" id="savetocredlylist" value="Save" />
      </div>

      <div id="newcredlylistdiv_step5" style="display:none;font-size:12px;">
        <input type="text" id="newcredlylisttext_step5" placeholder="Name of new Credly List"/><br/>
        <button class="btn btn-success btn-mini" id="savenewcredlylist">Save new list</button>
      </div>


    </div>

    <div id="step5finalmessage_1" style="display:none;">
      <p><label id="step5finalmessage_1label" style="color:green;">Recipients were successfuly added to the Credly list!<label></p>
      <strong><a href="<?php echo base_url('Integrations/sendbadge'); ?>" >Send another badge?</a></strong>
    </div>
  </div> 

  <!--  ------------------------------    END  STEP 5    --------------------------------------  -->

  
</div>




<div id="myModalhtml"  class="modal hide fade custom_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    <h3 id="myModalLabel">Customized MailChimp Template</h3>
  </div>
  <div class="modal-body" style="min-height:430px;">
    <iframe id="previewhtml" rameborder="0" scrolling="yes" style="min-height:420px;" width="100%" height="100%" ></iframe> 
    <!-- <textarea name="contents" id="textarea1" style="visibility:hidden;"></textarea> -->
    <textarea name="contents" id="textarea1"></textarea>

  </div>
  <div class="modal-footer">
    <!-- <button class="btn btn-info" id="btnConfirm" data-dismiss="modal" aria-hidden="true">Confirm</button> -->
    <button class="btn btn-primary" id="btnConfirm"  aria-hidden="true">Confirm</button>
    <!-- <button class="btn btn-primary">Save changes</button> -->
  </div>
</div>

<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-header">
    Please wait while the information is being processed....
  </div>
  <div class="modal-body">
    <div class="progress progress-striped active">
      <div class="bar" style="width: 100%;"></div>
    </div>
  </div>
</div>


<br/><br/>
<div class="alert alert-error" id="error-div"></div>



<!-- ///////////////////////// script /////////////////////////////////////////////////////////////////////////////// -->

<script type="text/javascript">

//   ------------------------     MAIN JAVASCRIPT      -------------------------------
var baseurl = "<?php print base_url(); ?>";


$('#sendcredit').click(function(e){
  var box = $("#textarea1");
  $('#templatehtmlasved').val(box.val());

});


$('#savenewcredlylist').click(function(e){

  var newCredlylist = $('#newcredlylisttext_step5').val();
  var list_id = $('#select_list_step5').val();
  var ids= [];
  var fn=[];
  var ln=[];
  var emails=[];
  var x=0;
  var i=0;
  var count;
  var data1;
  var array = [];

  $('.form-inline.contect-form').each(function(){

    dataString = $(this).serialize();
    array[x]=dataString;
    x = x + 1;
  });

  var badgeimagurl = $('#imgcredlybadge').attr("src");

  $.ajax({
    type: "POST",
    url: baseurl+"Integrations/sendbadge/savenewcontact",
    data: {newCredlylist:newCredlylist, dataString:JSON.stringify(array)},
    success: function(data){
      //alert(data);
      $('#newcredlylistdiv_step5').hide();
      $('#step5finalmessage_1').show();
      //$('#select_list_step5').attr("disabled", "disabled");
      //$('#savetocredlylist').attr("disabled", "disabled");
      $('#select_list_step5').hide();
      $('#savetocredlylist').hide();

    },
    dataType: 'html'
  });
});


$('#select_list_step5').change(function(e)
{
  var val = $('#select_list_step5').val();
  if (val == "newlist"){
   $('#newcredlylistdiv_step5').show();
   $('#savetocredlylist').hide();
 }

});


$('#savetocredlylist').click(function(e){

  var list_id = $('#select_list_step5').val();
  var ids= [];
  var fn=[];
  var ln=[];
  var emails=[];
  var x=0;
  var i=0;
  var count;
  var data1;
  var newCredlylist= "";


  var array = [];
  $('.form-inline.contect-form').each(function(){

    dataString = $(this).serialize();
    array[x]=dataString;
    x = x + 1;
  });

  var badgeimagurl = $('#imgcredlybadge').attr("src");


//$access_token, $email, $list_id, $first_name, $last_name
$.ajax({
  type: "POST",
  url: baseurl+"Integrations/sendbadge/savecontact",
  data: {list_id:list_id, dataString:JSON.stringify(array)},
  success: function(data){
    //alert(data);
    $('#step5finalmessage_1').show();
    $('#select_list_step5').attr("disabled", "disabled");
    $('#savetocredlylist').attr("disabled", "disabled");
  },
  dataType: 'html'
});


});


$('#myModalb, #preview_myModalb').click(function(e){


  $('#myModalhtml').modal();
  var templateid =$('#select_template_two').val();
  var badgeid =$("input[name=optionsRadiosBadge]").attr("value");


  if(templateid == 0 ){
    $('#error-div').show();
    $(".alert.alert-error").html("Please select the template first!!");
    e.stopPropagation();
    return false;

  }else{
    $.ajax({
      type: "POST",
      url: baseurl+"Integrations/sendbadge/gettemplateHtml",
      data: {templateid:templateid},
      success: function(data){
        var box = $("#textarea1");
        box.val(data);

         // var iframe= document.getElementById('previewhtml');
         // var iframedoc = iframe.contentDocument || iframe.contentWindow.document;
         // iframedoc.body.innerHTML = data;
         // iframe.refresh();


         document.getElementById('previewhtml').src = "data:text/html;charset=utf-8," + escape(data);
        //$("#previewhtml").val(data);

      },
      dataType: 'html'
    });

  }
});


//$('#datepicker').datepicker();
$(function() {
  $('#datetimepicker2').datetimepicker({
    language: 'en',
    pick12HourFormat: true
  });
});

////////////////// Add contacts from uploaded csv file  /////////////////////////////////////////
$('#csv-form-submit').submit(function(event){

  var ids= [];
  var fn=[];
  var ln=[];
  var emails=[];
  var x=0;
  var i=0;
  var count;
  var data1;

  event.preventDefault();

  $(this).ajaxSubmit({
    url: baseurl+"Integrations/sendbadge/upload_csv",
    dataType: 'json',
    success: function(response) {
      count = response["total_lines"].id;
      ////////  extract data from response /////////////////
      for(x=1; x<= count; x++){

        //ids[i]=response[x].id;
        ids[i]=count;
        fn[i]=response[x].first_name;
        ln[i]=response[x].last_name;
        emails[i]=response[x].email;
        i++;
      }

        ///////////////////////////// Append contacts ///////////////////// ///////////////////////
        var baseurl = "<?php print base_url(); ?>";
        $.ajax({
          type: "POST",
          url: baseurl+"Integrations/sendbadge/append_forms",
          data: {f_name:JSON.stringify(fn),l_name:JSON.stringify(ln),email_arr:JSON.stringify(emails),ids:JSON.stringify(ids)},
          success: function(data){
            $('#sendbadge-form').show();
            $('#sendbadge-form').append(data);
          },
          dataType: 'html'
        });
      }
    });

return false;
});


////////////////// Add contacts from uploaded csv file  /////////////////////////////////////////
$('#doc-form-submit').submit(function(event){

  event.preventDefault();
  
  $(this).ajaxSubmit({
    url: baseurl+"Integrations/sendbadge/upload_doc",
    success: function(response) {
     alert("File Successfully Attached..");
     $('#fileevidence').val(response);
   }
 });
  

});


// $('#select_templateone_auto').change(function(e){

//   $('#previewevidence').text("File attached..");


// });

$('#upload-doc-file').click(function(e){

  $('#previewevidence').text("File attached..");
  

});


$('#btnConfirm').click(function(e){
  $('#myModalhtml').modal('hide');

});



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$('#sendbadge-form').on('click','.icon-plus-sign.testimonial-plus',function(){
  $(this).next('span.icon-minus-sign.testimonial-minus').show();
  $(this).siblings('.testimonial-area').show();
  $(this).hide();

});
$('#sendbadge-form').on('click','.icon-plus-sign.evidence-plus',function(){

  $(this).next('.icon-minus-sign.evidence-minus').show();

  $(this).siblings('.evidence-area').show();
  $(this).hide();
});
$('#sendbadge-form').on('click','.icon-minus-sign.testimonial-minus',function(){

  $(this).prev('.icon-plus-sign.testimonial-plus').show();
  $(this).siblings('.testimonial-area').hide();
  $(this).hide();

});

$('#sendbadge-form').on('click','.icon-minus-sign.evidence-minus',function(){

  $(this).prev('.icon-plus-sign.evidence-plus').show();
  $(this).siblings('.evidence-area').hide();
  $(this).hide();


  $('#add-evidence-minus').hide();
  $('#add-evidence').show();
  $('#evidence-area').hide();
});
$('#recipient-checkbox').change(function(){
  if ($('#recipient-checkbox').is (':checked')){
    $('#recipient-message').show();
  }else{
    $('#recipient-message').hide();

  }
});

$('.add-recipient').click(function(){

  $.ajax({
    url: baseurl+"Integrations/sendbadge/add_sendbadge_form",
    success: function (data) {
      $('#sendbadge-form').show();
      $('#sendbadge-form').append(data);
    },
    dataType: 'html'
  });
});//add recip


$('#add-recipient-five').click(function(){

  for (i=0; i<5; i++){
    $.ajax({
     url: baseurl+"Integrations/sendbadge/add_sendbadge_form",
     success: function (data) {
      $('#sendbadge-form').show();
      $('#sendbadge-form').append(data);
    },
    dataType: 'html'
  });
  }
});//add recip

$('#sendbadge-form').on('click','.form-remove',function(){
  $(this).parent('.form-inline.contect-form').remove();
});



$('#select_timeoption').change(function(e){
  if($('#select_timeoption').val() == 1)
  {
   $('#datetimepicker2').show();
 }
 else 
 {
   $('#datetimepicker2').hide();
 }

});


$('#btnstep3').click(function(e){


  var selecttimeval= $('#select_timeoption').val();
  if (selecttimeval == "1"){

    var datepicker =$('#datepicker').val();
    if (datepicker == "")
    {
      alert("Please schedule a date and time first");
      return ;
    }
  }

  var listid = $('#select_list1').val();
  if (listid == "0")
  {
    alert("Please select a list first");
    return ;
  }


  $('#previewtestimonial-area').val($('#testimonial-area').val());


  if ($('#previewevidence').text() == "")
  {
    $('#previewevidence').text($('#gevidence').val());
  }

  if ($('#chkincludeemailnotifications').is(':checked'))
  {
   $('#previewincludeemailnotifications').text("Yes"); 
 }
 else
 {
   $('#previewincludeemailnotifications').text("No"); 
 }


 if($('#select_template_two').val()!=0)
 {
  $('#previewselect_template_two').text($('#select_template_two option:selected').html()); 
  $('#preview_editemailtemp').attr("href",baseurl +"template/edit/?id="+$('#select_template_two').val()+"&name="+$('#select_template_two option:selected').html());
}

if ( $('#select_template_two').val() != "0" || $('#select_templateone').val() == "true" || !$('#chkincludeemailnotifications').is(':checked'))
{
  $('#divstep1').hide();
  $('#divstep2').hide();
  $('#divstep3').hide();
  $('#divstep4').show();
  $('#bar').css('width', 75+'%');
}
else 
{
  alert("Please select a template first");
}

});



$('#btnstep4').click(function(e){


  $('#previewtestimonial-area').text($('#testimonial-area').val());


  var selecttimeval= $('#select_timeoption').val();
  var datepicker =$('#datepicker').val();
  


  if ($('#previewevidence').text() == "")
    $('#previewevidence').text($('#gevidence').val());
  // alert($('#gevidence').val());
  // alert($('#testimonial-area').val());
  var  html ;

  var templateid = $('#select_template_two').val();
  var badgeid =$('#imgcredlybadge').attr("badgeid");
  
  
  var chkincludeemailnotifications = true;
  //var chkincludeemailnotifications = false;
 //  if ($('#chkincludeemailnotifications').is(':checked'))
 //  {
 //   chkincludeemailnotifications = true; 
 // }else{
 //   templateid =1;
 // }

 var usercredlydefault = false;
 //alert($('#select_templateone').val());
 if ($('#select_templateone').val() == "true")
 {
   usercredlydefault = true;
   templateid =1;
 }

 var includecustommessage = false;
 if ($('#chkincludecustommessage').is(':checked'))
 {
   includecustommessage = true;
 }

 var custommessage = '';
 custommessage = $('#txtincludecustommessage').val();
 
 if(templateid == 0 || badgeid == 0)
 {
  $('#error-div').show();
  $(".alert.alert-error").html("Selection of Mailchimp list, badge and template is mandatory");
  e.stopPropagation();
  return false;
}else{
  $('#error-div').hide();


  var array = [];
  var x = 0;
  var dataString='';
  var listid = $('#select_list1').val();


  var gtestimonial =$('#previewtestimonial-area').val();
  var gevidence =$('#gevidence').val();
  
  if(gevidence == "")
    gevidence = $('#fileevidence').val();




  $('.form-inline.contect-form').each(function(){

    dataString = $(this).serialize();
    array[x]=dataString;
    x = x + 1;
  });

  var badgeimagurl = $('#imgcredlybadge').attr("src");
  
  $.ajax({
    type: "POST",
    url: baseurl+"Integrations/sendbadge/sendbadge_form",
    async: false,
    data: {dataString:JSON.stringify(array), templateid:templateid, listid:listid, badgeid:badgeid, html:html, gtestimonial:gtestimonial, gevidence:gevidence, custommessage:custommessage,includecustommessage:includecustommessage,chkincludeemailnotifications:chkincludeemailnotifications, usercredlydefault:usercredlydefault, badgeimagurl:badgeimagurl, selecttimeval:selecttimeval, datepicker:datepicker},
    success: function(data){

      var strdata =" "+data;
      if((strdata.search(" Error! "))<0){
        alert(data);
        
        $('#bar').css('width', 100+'%');
        $('#divstep4').hide();
        $('#divstep5').show();
        
      }
      else
      {

        $("#div_err_p").text(data);
        $("#div_err").delay('300').fadeIn();
        $("#div_err").delay('5000').fadeOut('slow');
      }
    },

    error:function(x,e)
    {

      if(x.status==0){
        alert('You are offline!!\n Please Check Your Network.');
      }else if(x.status==404){
        alert('Requested URL not found.');
      }else if(x.status==500){
        alert('Internel Server Error.');
      }else if(e=='parsererror'){
        alert('Error.\nParsing JSON Request failed.');
      }else if(e=='timeout'){
        alert('Request Time out.');
      }else {
        alert('Unknow Error.\n'+x.responseText);
      }
    }
  });
}

});


///////////////////////////////////////////// select credly list  //////////////////////////////////////////////////////////////
$('#select_lista').change(function(){

  pleaseWaitDiv.modal('show');

  var listid = $(this).val();
  $.ajax({
    type: "POST",
    async: true,
    url:  baseurl +"Integrations/sendbadge/popup_form",
    data: {listid:listid},
    success: function(data){

      pleaseWaitDiv.modal('hide');
      $('#popup-parent-div').html(data);
      $(this).show();
      $('#myModalpopup').modal('show');

    },
    error:function(x,e)
    {

      if(x.status==0){
        alert('You are offline!!\n Please Check Your Network.');
      }else if(x.status==404){
        alert('Requested URL not found.');
      }else if(x.status==500){
        alert('Internel Server Error.');
      }else if(e=='parsererror'){
        alert('Error.\nParsing JSON Request failed.');
      }else if(e=='timeout'){
        alert('Request Time out.');
      }else {
        alert('Unknow Error.\n'+x.responseText);
      }
      pleaseWaitDiv.modal('hide');
    },

    dataType: 'html'
  });
  

});

///////////////////////////////////////////// select credly list  //////////////////////////////////////////////////////////////
$('#type_name').change(function(){
  pleaseWaitDiv.modal('show');

  var listid = $(this).val();
  $.ajax({
    type: "POST",
    async: true,
    url:  baseurl +"Integrations/sendbadge/popup_form_mailchimp",
    data: {listid:listid},
    success: function(data){

      pleaseWaitDiv.modal('hide');

      $('#popup-parent-div').html(data);
      $(this).show();
      $('#myModalpopup').modal('show');

    },
    error:function(x,e)
    {
      pleaseWaitDiv.modal('hide');
      if(x.status==0){
        alert('You are offline!!\n Please Check Your Network.');
      }else if(x.status==404){
        alert('Requested URL not found.');
      }else if(x.status==500){
        alert('Internel Server Error.');
      }else if(e=='parsererror'){
        alert('Error.\nParsing JSON Request failed.');
      }else if(e=='timeout'){
        alert('Request Time out.');
      }else {
        alert('Unknow Error.\n'+x.responseText);
      }
    },
    dataType: 'html'
  });
});

</script>