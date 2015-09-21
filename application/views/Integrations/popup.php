<!-- Modal -->
<div id="myModalpopup" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    <h3 id="myModalLabel">Add Contacts From List</h3>
  </div>
  <div class="modal-body">
    <table class="table table-striped">
      <thead>
        <th>Contact</th>
        <th><input type="checkbox" name="checkbox_all" id="checkbox_all" class="select_members_all" /> Select All </th>
      </thead>
      <tbody>
        <?php 
        
        if ($mailchimp == "N")
        {

          foreach ($records as $record) { ?>
          <tr>
            <td><?php echo $record->email; ?></td>
            <td>
              <input type="checkbox" name="checkbox" class="select_members" value="<?php echo $record->id; ?>" />
              <input type="hidden" name="first_name" class="first_name" value="<?php echo $record->first_name; ?>" /> 
              <input type="hidden" name="last_name" class="last_name" value="<?php echo $record->last_name; ?>" />   
              <input type="hidden" name="email" class="email" value="<?php echo $record->email; ?>" />
              <input type="hidden" name="contact_id" class="contact_id" value="<?php echo $record->id; ?>"/>
            </td>
          </tr>
          <!-- </li>  -->
          <?php } 
        }
        else {
          foreach ($records as $member) { ?>
          <tr>
            <td><?php echo $member['merges']['EMAIL']; ?></td>
            <td>
              <input type="checkbox" name="checkbox" class="select_members" />
              <input type="hidden" name="email" class="email" value="<?php echo $member['merges']['EMAIL']; ?>" />
              <input type="hidden" name="first_name" class="first_name" value="<?php echo $member['merges']['FNAME']; ?>" />
              <input type="hidden" name="last_name" class="last_name" value="<?php echo $member['merges']['LNAME']; ?>" />
             
            </td>
          </tr>
          <!-- </li>  -->
          <?php }
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary save-select-members">Save changes</button>
  </div>

</div>

<!-- ///////////////////////// script /////////////////////////////////////////////////////////////////////////////// -->

<script type="text/javascript">

var baseurl = "<?php print base_url(); ?>";

$('#checkbox_all').click(function(e){

  if($('#checkbox_all').is(':checked'))  
  {

    $('.select_members').each(function(){
      $(this).prop('checked', true);
    });
  }
  else
  {
    $('.select_members').each(function(){
      $(this).prop('checked', false);
    }); 
  }

});


$('.save-select-members').on('click',function(){
 $('#myModalpopup').modal('hide');
 var arr = [];
 
 var ids = [];
 var fn=[];
 var ln=[];
 var emails=[];
 var x = 0;
 var flag = 0;
 var existedForm;
 var dataString='';
 var count = 0;

 var flag = 0;
 var old_fname='';
 var old_lname='';
 var old_email='';
 var fn1='';
 var ln1='';
 var email1='';



 $('.select_members').each(function(){


  var val = $(this).val();
  if($(this).is(':checked'))
  {
    count++;
    var checkedDiv = $(this);


    $('.form-inline.contect-form').each(function()
    {
      var emptyformId = $(this).data('contects-id');
      if(emptyformId == '')
      {
        $(this).remove();
      }

    });

    $('.form-inline.contect-form').each(function(){
      var formContectId = $(this).data('contects-id');
      if (val == formContectId){
        flag = 1;
        existedForm = $(this);
      }
    });

    if (flag == 1)
    {
      old_fname= existedForm.siblings('.first_name').val();
      old_lname = existedForm.siblings('.last_name').val();
      old_email = existedForm.siblings('.email').val();

      fn1 = $(this).siblings('.first_name').val();
      ln1 = $(this).siblings('.last_name').val();
      email1 = $(this).siblings('.email').val();
      if(old_fname!=fn1 || old_lname!=ln1 || old_email!=email1){
        flag = 0;
        existedForm.remove(); 
      }
    }

    if (flag == 0)
    {
      ids[x] = val;
      fn[x] = $(this).siblings('.first_name').val();
      ln[x] = $(this).siblings('.last_name').val();
      emails[x] = $(this).siblings('.email').val();
      x = x + 1;            
    }
  } 
});



$('#labelnumberofrecipients').show();
$('#labelnumberofrecipients').text(count+" recipients selected");

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

});

</script>



