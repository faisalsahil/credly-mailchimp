

<div style="background-color:#ffffff;">

	<div class="navbar navbar-inverse navbar-fixed-top" style="width:100%;">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?php base_url(''); ?>"><img src="https://credlysites.s3.amazonaws.com/1386534093.credly-mailchimp-logos.png" /></a><br/>

			</div>
		</div>
	</div>


	<div class="row">

		<div class="login-form">
			<div id="left_content"><br><br><br><br>
				<h3>Credly MailChimp App</h3>
				Recognizing achievement has never been easier or more beautiful. <br/>
				Two of your favorite tools come together in one really useful app: <br/><br/>
				<ul>
					<li>Send new badge notifications using your MailChimp email templates</li>
					<li>Easily bulk issue badges to members of any MailChimp list</li>
					<li>Set up rules to automatically issue badges as people join MailChimp lists</li>
					<li>Manage, pause, or edit Automatic MailChimp Badge Issuing Rules</li>
				    <li>Track your badge campaign through MailChimp</li>
			</ul>
				All you need is a Credly account and a MailChimp account.<br/>  Login and get started now! <br/><br/>
			
			</div>	
		</div>
		<div class="clearfix" style="padding:30px;">
			<div id="login_form">	
				<h3>Login</h3>
				<b>Enter Your Credly Username & Password</b><br/>	
				<?php if(! is_null($msg)) echo $msg;?>
				<form action="<?php echo base_url();?>login/login/process" method="post" name="process">
					<fieldset>

						<div class="clearfix">
							<input type="text" name='email' id='email' placeholder="Email">
						</div>
						<div class="clearfix">
							<input type="password" name="password" id='password' placeholder="Password">
						</div>
						<button class="btn btn-primary" type="submit">Sign in</button>
						<a target="_blank" href="https://credly.com/#!reset-password">Forgot Password ?</a>
					</br></br></br>
					<strong>Not yet a Credly member ? <br/>
						<a target="_blank" href="https://credly.com/#!/create-account">Join now (it's free)</a>
					</strong>
				</fieldset>
			</form>
		</div>
		
		<div id="monkey_icon">
			<img src="https://credlysites.s3.amazonaws.com/1386534255.mailchimp_badge_shield.png" height="32" alt="some_text"> 
		</div>
		<div id="right_content">
			<h3>Reward Members, Honor Achievement</h3>
			There are many ways to use the Credly MailChimp App. Here are just a few:<br/><br/>

				<ul>
			    <li>Put your brand front and center and add context to your badge notification emails</li>
			    <li>Issue sharable Credly badges to acknowledge new members of your community</li>
			    <li>Use a MailChimp sign-up form and allow people to claim a badge they deserve </li>
			    <li>Automatically issue badges as people register for or attend your events</li>
			    <li>Reward loyal customers with limited edition badges</li>
			    <li>Endless badge-issuing potential through MailChimps hundreds of available app integrations</li>
			    <li>Magnify the impact of campaigns as recipients proudly share badges on social networks</li>
			    <li>And so much more ...
			</ul>

		</div>
	</div>
</div>
