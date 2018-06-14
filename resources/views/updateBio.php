<html>
  <title>Update bio</title>
  <body>
    <div id='update_number'>
      <?php if(isset($message)){echo $message; } ?>
      <form method='post' action='<?php echo url('/updateBio')?>'>
        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
        <label>your new number</label> <input type='tel'  name='phone'>
        <label> reenter your new number</label> <input type='tel'  name='phone1'>
        <input type= 'submit' value='update number'>
      </form>
    </div>
    
     <div id='update_bio'>
      <?php if(isset($message)){echo $message; } ?>
      <form method='post' action='<?php echo url('/updateBio')?>'>
        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
        <textarea rows="10" cols="15" name ='bio'> input your Bio</textarea>
        <input type= 'submit' value='update Bio'>
      </form>
    </div>
    
     <div id=update_image>
      <?php if(isset($errormsg)){echo $errormsg; } ?>
      <form method='post' action='<?php echo url('/updateBio')?>' enctype='multipart/form-data'>
        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
        <label>Select image file of type JPG, Png, JPEG or Gif</label><input type='file' name= 'image'>
        <input type= 'submit' value='update profile photo'>
      </form>
    </div>
    
     <div id='update_password'>
      <?php if(isset($errormsg)){echo $errormsg; } ?>
      <form method='post' action='<?php echo url('/updateBio')?>'>
        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
        Old password: <input type='password' name= 'old_password'>
        new password: <input type= password name= 'new_password'>
       reenter new password: <input type= password name= 'new_password1'>
       <input type="submit" value="change password">
      </form>
    </div>
    
    <form> <button formaction='<?php echo url('/dashboard')?>' id='dash'> click to return to your dashboard</button></form>
  
  </body>
</html>