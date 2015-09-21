<div class="row-fluid">

  <div class="hero-unit">
    <h3>Settings</h3>
    <!-- mailchimp form -->
    <div class="well">
      <fieldset>
        <p style="font-size: 12px;">To start using the Credly MailChimp app, you firsr need <br> to enter and save your MailChimp API key:</p><br/><br/>
        <?php if($MCkey){ ?>
        <p style="font-size: 12px;" class="alert alert-success" >Key :<i><strong><?php echo $MCkey; ?></strong></i><br>
          List : <i><strong><?php echo $McList; ?></strong></i><a class="pull-right" id="changeMC">Change</a></p>
          <?php }elseif($MCkey == ''){ ?>
          <script>
          $(document).ready(function() {
            $('.MCkeyform').show();
          });
          </script>
          <?php } ?>
          <div class="MCkeyform">
            <form class="form-inline" name="frm_MC" id="frm_MC" method="post" action="<?php echo $actionMC; ?>">
              <input type="hidden" name="type" value="MC">
              <input type="text" class="input-large" id="key" name="key" placeholder="Enter MailChimp Api Key">
              <input type="button" class="btn btn btn-success" id="get_list" value="Get MailChimp Lists">
              <select name="list" id="MClists">
                <option value="0" select="selected">Select a List</option>
              </select>
              <button type="submit" class="btn btn-success">Save</button>
              <span id="closeMcFrm" class="icon-remove pull-right">&nbsp;</span>
            </form>

          </div>
          <div style="font-size: 12px;">
            <a target="_blank" href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key">How do I get my MailChimp API key ?</a><br><br>
            Don't have a MailChimp account?<br><a target="_blank"  href="http://mailchimp.com/">Join MailChimp</a> 

          </div>

        </fieldset>
      </div>
    </div>   
  </div>
</div>
