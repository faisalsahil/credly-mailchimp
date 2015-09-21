<div class="container-fluid">
	<div class="container">
		<div class="content" style="width:300px;">
			<div class="row">
				<div class="login-form" >
					<h3>Create an account!</h3>
					
					<!--<?php// if(!isset($status) && !is_null($msg)) echo $msg;?> -->

					<form action="<?php echo base_url();?>Registration/Signup/process" method="post" name="process">
						<fieldset>
							<div class="clearfix">
								<input type="text" name='username' id='username' placeholder="Display Name">
							</div>
							<div class="clearfix">
								<input type="text" name='email' id='email' placeholder="*Email" required>
							</div>
							<div class="clearfix">
								<input type="text" name='fname' id='fname' placeholder="First Name">
							</div>
							<div class="clearfix">
								<input type="text" name='lname' id='lname' placeholder="Last Name">
							</div>
							<div class="clearfix">
								<input type="password" name="password" id='password' placeholder="*Password" required>
							</div>
							<div class="clearfix">
								<input type="password" name='confirmpassword' id='confirmpassword' placeholder="*Password again" required>
							</div>
							<button class="btn btn-primary" type="submit">Sign Up Now</button><br /><br /><br />
							<a href="<?php echo base_url();?>login/login"> Login using credly?</a>

						</fieldset>
						<span></span> <br /><br />
						<?php if (isset($status)) { ?>
						<?php if ($status === "1") { ?>
						<div class="alert alert-success">
							<?php echo $msg ?>
						</div>

						<?php }else { ?>

						<div class="alert alert-error">
							<?php echo $msg ?>
						</div>

						<?php } }?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>