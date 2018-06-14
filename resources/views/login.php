


<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <blockquote>
            <form action="<?php echo url('/login'); ?>" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                <?php if (isset($errormsg)){
                echo $errormsg.'<br>';
                }?>
                Email:   <input type ="email" name = "email"><br>
                Password:<input type ="password" name="password"><br>
                         <input type="submit" value="LOG IN"/> <br>
            </form>
            
        </blockquote>
        <div id= 'passwordreset'>
            <form> <button formaction="<?php echo url('/password/email'); ?>"> reset password </button></form>
        </div>
    </body>
</html>