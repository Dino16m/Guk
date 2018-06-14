<!DOCTYPE html>
<html>
  
    <head>
      
        <meta charset="UTF-8">
        <title>Dashboard of <?php echo $user['name'] ?></title>
    </head>
    <body>
        <img alt="Your Profile picture" id ='display_pic' src="<?php if(isset($user['image'])){
        echo url($user['image']);
          
        }
        
        ?>" >
        <div id= account_actions>
               <ul>
                   <li> <form> <button formaction="<?php echo url('/updateBio')?>" id='update_bio'>update bio</button></form></li>

                   <li>   <form><button formaction="<?php echo url('/logout') ?>" id = 'logout' name= logout value= logout>logout</button></form> </li>
              </ul>
           </div>
    </body>
</html>