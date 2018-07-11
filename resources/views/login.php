


<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
      
            <form action="<?php echo url('/login'); ?>" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
               
                <div class="form-login">
                    <div class="container">
                    <ul>
                        <li>      
                            <label for='email'>Email: </label>  
                            <input type ="email" name = "email" id='email'>
                        </li>
                        <li>
                            <label for='pwd'> Password: </label> 
                            <input id ='pwd' type ="password" name="password"><br>
                        </li>
                   
                         
                        <li>  
                            <input type="submit" value="log in" id='login'>
                        </li>
                    <li> <a href="<?php echo url('resetPassword')?>"> <b>Reset Password</b></a></li>
                    </ul>
                    </div>
                 
        </div>
            </form>
            
        
       
        <script type="text/javascript" src="<?php echo url('js/app.js') ?>"> </script>
       
    </body>
</html>
