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
        <form action="<?php echo url('posts')?>" method="Post"> 
         <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
       post title:  <input type='text' name="title">
         Post content: <input type='text' name="content">
        user identity: <input type='text' name='user'>
         <input type="submit">
        
        </form>
    </body>
</html>
