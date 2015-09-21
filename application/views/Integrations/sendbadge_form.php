 <form class="form-inline contect-form" name="frm_MC1" id="frm_MC1" method="post" data-contects-id="<?php  if(isset($con_id)){echo $con_id;} else {echo "1";} ?>" >

  <a id="close-form" class="icon-remove form-remove pull-right" ></a>
  

    <?php if(isset($f_name)) {?>
    <input type="text" class="fname" name="fname" id="fname" placeholder="First Name" value="<?php echo $f_name; ?>" style="width:250px" required />
    <?php }else{ ?>
    <input type="text" class="fname" name="fname" id="fname" placeholder="First Name" style="width:250px"  required/>
    <?php }?>


    <?php if(isset($l_name)) {?>
    <input type="text" class="lname" name="lname" id="lname" placeholder="Last Name" value="<?php echo $l_name; ?>" style="width:250px" required />
    <?php }else{ ?>
    <input type="text" class="lname" name="lname" id="lname" placeholder="Last Name" style="width:250px" required />
    <?php }?>

    <?php if(isset($email)) {?>
    <input type="text" class="email" name="email" id="email" placeholder="Email Address" value="<?php echo $email; ?>" style="width:250px" required />
    <?php }else{ ?>
    <input type="text" class="email" name="email" id="email" placeholder="Email Address" style="width:250px;" required />
    <?php }?>


</form>


