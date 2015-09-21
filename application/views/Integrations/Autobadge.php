<style type="text/css">
.dataTables_info{display: none;}
.dataTables_length label {display: none;}
.dataTables_filter input {margin-left: 9px;}
</style>
</style>


<div class="row-fluid" style="float:left;min-width: 1250px;">
  <div class="hero-unit">
    <div class="well" style="font-size:12px;">

     <ul class="breadcrumb" >
      <li><a href="#">Issue Badges</a> <span class="divider">/</span></li>
      <li class="active">Auto MailChimp Badges</li>
      </ul>


    <!-- //........................             STEP 1    ............................../// -->
    <div id="autobadgestep1">
      <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-hover" style="font-size:12px;" id="tt_AC">
        <thead>
          <th>Badge</th>
          <th>Badge ID</th>
          <th>Title</th>
          <th>MailChimp List</th>
          <th>Actions</th>
          <th>Rule Status</th>
        </thead>   
        <tbody>
          <tr>
            <?php if (isset($count) && $count>0) {
              foreach($badges->result() as $row)
                { ?>
              <form>
                <td><img src=<?php echo $row->path ?> alt="Credly Badge" height="42" width="42"/> </td>
                <th><?php echo $row->badge_id; ?></th>
                <td><?php echo $row->badge_title; ?></td>
                <td><?php echo $row->list_name; ?></td>
                <td><a id="destroy" href="<?php echo site_url('Integrations/Autobadge/'); ?>/destroy/?bid=<?php echo $row->badge_id; ?>&lid=<?php echo $row->list_id; ?>" class="btn btn-mini btn-danger">Delete</a></td>
                <td> 
                  <div class="label2-toggle-switch make-switch switch-small" value="<?php echo $row->badge_id; ?>" listname="<?php echo $row->list_name; ?>">
                    <input type="checkbox" <?php if($row->include === '1') { ?> checked   <?php }?> />
                  </div>
                </td>

              </form>

            </tr>
            <?php }}?>
          </tbody>
        </table> <br/> <br/>
        <a class="btn btn-primary pull-right" id="addautobadge">Add Auto-Badge</a><br/> 
      </div>

      <!-- //........................             STEP 2    ............................../// -->


      <div id="autobadgestep2" style="display:none;" >

        <!--  FORM START -->
        <form class="form-inline float-left" name="frm_autobadge" id="frm_autobadge" method="post" action="<?php echo base_url();?>Integrations/Autobadge/Saveautobadge">
          <!-- <form class="form-inline float-left" name="frm_autobadge" id="frm_autobadge" method="post" > -->
          <h3>Add Auto Badge MailChimp Rule</h3>
          <p style="font-size:12px; margin-top: -18px;">Automatically issue any Credly badge when someone new joins a MailChimp list. <br/><br/></p>

          <strong >1. First, select one of your MailChimp Lists.<br/></strong>
          <select style="font-size:12px;" name="list" id="MClists" style="width:375px;">
            <option value="0" select="selected"> Select a MailChimp List</option>
            <?php 
            foreach ($lists as $list) { ?>
            <option value=<?php echo $list['id'];?>-<?php echo $list['name'];?> > <?php echo $list['name']; ?></option>
            <?php } ?>
          </select><br/><br/>

          <p>Need a new MailChimp list? <a target="_blank" src="https://admin.mailchimp.com/lists/">Create one now.</a><br/></p>
          <hr>
          <div id="divstep1" >
            <div>
              <strong >2. Select one Credly batch you'd like to automatically issue when someone joins the list you selected above.<br /></strong>
              <p > Need a new Credly badge? <a target="_blank" href="https://credly.com/badge-builder">Create one now.</a> <br/></p>
            </div>
            
            <?php //include('application/views/Integrations/select_badge_form.php') ?>

            <table class="table table-bordered table-striped table-hover">
              <thead>

                <th style="width:1px;"></th>
                <th style="width:1px;">Badge</th>
                <th>Title</th>
                <th>Short Description</th>
                <th>ID</th>

              </thead>   
              <tbody>
                <?php for($x=0;$x<$count1; $x++){  ?> 
                <tr>
                  <td><input type="radio" name="Badges_lists" id="Badges_lists" alt="<?php echo $badges1[$x]->title; ?>"  value="<?php echo $badges1[$x]->id; ?>" src="<?php echo $badges1[$x]->image_url; ?>"></td>
                  <td><img src=<?php echo $badges1[$x]->image_url; ?> alt="Credly Badge" height="42" width="42"/> </td>
                  <td><?php echo $badges1[$x]->title; ?></td>
                  <td><?php echo $badges1[$x]->short_description; ?></td>
                  <td><?php echo $badges1[$x]->id; ?></td>

                </tr>
                <?php } ?>
              </tbody>
            </table>

            <hr>

          </div>



          <!-- BADGES DATA  -->
          <!-- <span>Badges:</span> -->
           <!--  <select name="Badges_lists" id="Badges_lists" >
             <?php for($x=0;$x<$count1; $x++){ ?> 
             <option value="<?php echo $badges1[$x]->id; ?>" > <?php echo $badges1[$x]->title; ?></option>
             <?php } ?>

           </select>
         -->


         <?php for($x=0;$x<$count1; $x++){ ?>
         <?php echo '<input type = "hidden" name = "title-' . $badges1[$x]->id . '" value = "' . $badges1[$x]->title . '">'; ?>
         <?php echo '<input type = "hidden" name = "image-url-' . $badges1[$x]->id . '" value = "' . $badges1[$x]->image_url . '">'; ?>
         <?php } ?>
         <!-- END BADGES DATA  -->


         <input type="hidden" name="fileevidence" id="fileevidence" type="text" value=""/>
         <input type="hidden" name="hiddentestimonial" id="hiddentestimonial" type="text" value=""/>
         <input type="hidden" name="hiddencustommessage" id="hiddencustommessage" type="text" value=""/>
         <input type="hidden" name="hiddenemailnotificationflag" id="hiddenemailnotificationflag" type="text" value=""/>
         <input type="hidden" name="hiddendefaultcredly" id="hiddendefaultcredly" type="text" value="1"/>
         <input type="hidden" name="hiddentemplateid" id="hiddentemplateid" type="text" value="1"/>

         <!-- FORM SUBMIT  -->

         <span id="closeMcFrm" >&nbsp;</span>
        </form>



       <!-- EVIDENCE -->
          <!-- <span id="add-evidence_all" class="icon-plus-sign evidence-plus"></span>
           <span id="add-evidence-minus_all" class="icon-minus-sign evidence-minus"  style="display:none;"></span> -->
           <div id="evidence">
             <strong> 3. Include Evidence (optional)</strong> <br/><br/>

             <!-- <div id="divadd-evidence_all" style="display:none;"> -->
             <p>The link or file you attach will be included with every badge 
              issued as evidence of the recipient's achievement. <br/></p>

              <form enctype="multipart/form-data" action="<?php echo base_url();?>Integrations/autobadge/upload_doc" method="POST" id="doc-form-submit">
                <label>Enter a URL:</label>
                <input id="autobadgegevidence" name="autobadgegevidence" type="text" placeholder="http://" />
                <div>
                  - or -     
                  <input type="file" class="doc-file"  name="doc-file" id="doc-file" value="http://" /> 
                </div>
                <input type="submit" class="btn btn-primary btn-mini" name="upload-doc-file" id="upload-doc-file" value="submit" /> <br/><br/>
              </form>
            </div>
            <div id="vertical_line"></div>


            <!-- END EVIDENCE -->

            <!-- TESTIMONIAL -->
          <!-- <span id="add-testimonial_all" class="icon-plus-sign testimonial-plus"></span>
          <span id="add-testimonial-minus_all" class="icon-minus-sign testimonial-minus" style="display:none;"></span> -->
          <div id="testimonial">
            <strong>4. Include Testimonial (optional) </strong><br/><br/>
            <!-- <div id="divadd-testimonial_all" style="display:none;"> -->
            <p >The testimonial you include here will be included with every badge.
             Tell the world why this person deserves this badge. (Tip: Avoid using names or pronouns, 
             since you may not know in advance specifically who will earn this badge.)<br/></p>
             <textarea name="autobadgetestimonial-area" id="testimonial-area" class="testimonial-area" maxlength="2000" placeholder="Write testimonial here" style="width:300px; height:80px;"></textarea><br/>
           </div>

           <!-- </div> -->
           <!-- END TESTIMONIAL -->
           <div style="margin-top:55px;">
            <hr>
            <strong>5. Email notification</strong>


            <p >Select the kind of notification that will be sent to recipients upon joining your list and earning the selected <br>badge.</p><br>

            <div id="select_template_twodefault_custommessage" >
             

              <div>
                <select id="select_templatetype_auto" style="font-size:12px;min-width:350px;right-margin:5px;">
                  <option value="true">Send default Credly notification email</option>
                  <option value="false">Use one of my MailChimp email templates</option>
                </select>
              </div>
              <br/>

              <div id="includecustommessage_auto" >
                <input id="chkincludecustommessage" type="checkbox" checked/>
                Include custom message? (This appears in the email notification to badge recipients.)<br/>
                <div id="divincludecustommessage" >
                  <br/>
                  <textarea name="txtincludecustommessage" id="txtincludecustommessage" class="testimonial-area" maxlength="2000" placeholder="Include custom message here"  style="width:500px; height:80px;"></textarea><br/>
                </div>
              </div>

              <div id="select_template_twodefault_auto" style="display:none">
                <select style="font-size:12px;" name="select_template_two_auto" id="select_template_two_auto" >
                  <?php foreach($templates as $template) { ?>
                  <option value="<?php echo $template->id ?>" ><?php echo $template->templatename; ?></option>
                  <?php } ?>
                </select>
                <span style="margin-left:20px;"></span>
              </div>

            </div >
          </div>
          <hr>

          <p> Click the button below to add this rule. It will become active immediately, and new members
           of the designated list will receive the badge upon joining.</p>
           <!--END FORM  -->

         </div>


         <?php if (isset($msg)) { ?>
         <br/><br/>
         <div class="alert alert-success">
           <?php echo $msg; ?>

         </div>
         <?php } ?>


       </div>


       <button type="submit" id="submit_frm_autobadge" class="btn btn-primary pull-left" style="display:none">Create Rule Now</button>


     </div><!--/span-->
    </div><!--/span-->



   <script type="text/javascript">

//   ------------------------     MAIN JAVASCRIPT      -------------------------------

  $(document).ready(function() {
    $('#tt_AC').dataTable( {
        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
    } );
} );
var baseurl = "<?php print base_url(); ?>";


$('#select_templatetype_auto').change(function(){

 var val= $('#select_templatetype_auto').val();

 if (val == "true"){
   $('#includecustommessage_auto').show();
   $('#select_template_twodefault_auto').hide();
   
 }
 else 
 {
  $('#includecustommessage_auto').hide();
  $('#select_template_twodefault_auto').show();
}

});



$('.label2-toggle-switch').on('switch-change', function(e, data) {

  var badgeid = $(this).attr('value');
  var listname = $(this).attr('listname');
  var include = data.value;

  $.ajax({
    type: "POST",
    url:  baseurl +"Integrations/Autobadge/ChangeCheckedStatus",
    data: {listname:listname, badgeid:badgeid, include:include},
    success: function(data){
     //alert(data);
   },
   dataType: 'html'
 });

});

$('#addautobadge').click(function(event){

  $('#autobadgestep1').hide();
  $('#autobadgestep2').show();
  $('#submit_frm_autobadge').show();


});


$('#submit_frm_autobadge').click(function(){

 if ($('#MClists').val()== "0")
 {
   alert("You must select a Mailchimp list before this rule can be created."); 
   return;
 }

 if($('input:radio[name="Badges_lists"]').is(':checked')) 
 { 
  $('#frm_autobadge').submit();
  $('#autobadgestep2').hide();
  $('#submit_frm_autobadge').hide();
  $('#autobadgestep1').show();

}
else 
{
  alert("You must select a Credly badge before this rule can be created."); 
}

});

$('#frm_autobadge').submit(function(event){

  if($('#autobadgegevidence').val() != ""){
   $('#fileevidence').val($('#autobadgegevidence').val());
 }
 $('#autobadgestep1').hide();

 if($('#chkemailnotifications').is(':checked')){
   $('#hiddenemailnotificationflag').val('1');
 }
 else{
   $('#hiddenemailnotificationflag').val('0');
 }
 
 $('#hiddencustommessage').val($('#txtincludecustommessage').val());
 $('#hiddentestimonial').val($('#testimonial-area').val());


 if( $('#select_templatetype_auto').val() == "false" )
 {
   $('#hiddendefaultcredly').val('0');
 }
 
 $('#hiddentemplateid').val($('#select_template_two_auto').val());


 // var MClists = $('#MClists').val();
 // var fileevidence = $('#fileevidence').val();
 // var hiddentestimonial = $('#hiddentestimonial').val();
 // var hiddencustommessage = $('#hiddencustommessage').val();
 // var hiddenemailnotificationflag = $('#hiddenemailnotificationflag').val();
 // var badgeid =$("input[name=optionsRadiosBadge]").attr("value");

//  alert(badgeid);
//  alert(MClists);
//  alert(fileevidence);
//  alert(hiddentestimonial);
//  alert(hiddencustommessage);
//  alert(hiddenemailnotificationflag);

//  $.ajax({
//   type: "POST",
//   url:  baseurl +"Integrations/Autobadge/Saveautobadge",
//   data: {MClists:MClists,fileevidence:fileevidence, hiddentestimonial:hiddentestimonial, hiddencustommessage:hiddencustommessage, hiddenemailnotificationflag:hiddenemailnotificationflag},
//   success: function(data){
//    //redirect('Integrations/Autobadge', 'refresh');
//  },
//  dataType: 'html'
// });

 //event.preventDefault();

});


////////////////// Add contacts from uploaded csv file  /////////////////////////////////////////
$('#doc-form-submit').submit(function(event){
  event.preventDefault();
  $(this).ajaxSubmit({
    url: baseurl+"Integrations/sendbadge/upload_doc",
    success: function(response) {
     alert("File Successfully Attached..");
     if($('#autobadgegevidence').val() == "")
       $('#fileevidence').val(response);
   }
 });
});

</script>