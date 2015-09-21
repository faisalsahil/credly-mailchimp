 <div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <a class="brand" href="<?php echo base_url('common/settings/home'); ?>"><img src="https://credlysites.s3.amazonaws.com/1386534093.credly-mailchimp-logos.png" /></a><br/>
      <div class="nav-collapse collapse">
        <?php if($this->session->userdata('email')){?>
        <p class="navbar-text pull-right">
          Logged in as <a href="#" class="navbar-link"><?php echo $this->session->userdata('email');?></a> | <a href="<?php echo base_url('login/login/do_logout');?>" class="">Logout</a>
        </p>
        <?php } ?>
        <ul class="nav">
          <li><a href="<?php echo base_url('template'); ?>">Email Templates</a></li>
          <li class="dropdown">
            <a data-toggle="dropdown" href="#">Issue Badges</a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
              <li><a href="<?php echo base_url('Integrations/Autobadge'); ?>">Automatic MailChimp Badges</a></li>
              <li><a href="<?php echo base_url('Integrations/sendbadge'); ?>">Send Badge Now</a></li>
            </ul>
          </li>
          <li><a href="<?php echo base_url('common/settings'); ?>">Settings</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
