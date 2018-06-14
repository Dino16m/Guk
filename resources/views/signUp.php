

<html>
    <head>
        <title>SIGNUP PAGE</title>
    </head>
    <body>
        <form action= <?php echo("/signUpcontroller"); ?> method="POST">
       <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
            Name:<input type="text" name="tname" id="tname"/><br>
             Email: <input type="email" name="email"/><br>
             Phone:<input type="text" name='number'>
            Password: <input type="password" name="password"/><br>
            Password1: <input type="password" name="password1"/><br>
            <input type="submit" value="Sign up"/> <br>
            <?php
            if(isset($errormsg)){
          echo $errormsg;
              
            }
           ?>
        </form>
        
    
    </body>
</html