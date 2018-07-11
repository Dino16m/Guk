<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       <?php 
       $commlength = sizeof($comments);
       for ($i=0; $i<$commlength; $i++){
           echo 'Comments: '. $comments[$i]->comment_content.'<br><hr>';
           // echo 'replies'. $replies[$i]->comment_content.'<hr>';
           foreach($replies[$i] as $reply){
               echo 'replies: '.$reply->comment_content.'<hr>';
           }
       }
       ?>
    </body>
</html>
