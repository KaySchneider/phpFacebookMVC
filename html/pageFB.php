<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml">
   <head>
<?php
print $this->addMetaTags();
?>
      <title><?php print $this->addHeaderInfo(); ?></title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <link rel="stylesheet" type="text/css" href="css/fbstyles.css"/>
      <link rel="stylesheet" type="text/css" href="css/menue.css"/>
      <link rel="stylesheet" type="text/css" href="css/startFB.css"/>
      <script src="js/jquery-1.6.min.js" language="javascript"></script>
      
      <!--<script src="http://connect.facebook.net/de_DE/all.js"></script>-->
      
      <meta name="keywords" content="add here some keywords" />
      <meta name="description" content="iLike <?php print $this->addHeaderDescription(); ?>" />
      <meta name="author" content=" Kay Schneider" />
      <meta name="copyright" content="2010, Kay Schneider" />
      <meta name="revisit-after" content="2 Days" />
      <meta name="expires" content="never" />

      


   </head>
   <body >

      <div id="chat_invite_container" style="position: absolute; left: 100px; top: 200px"></div>
      <div id="fb-root"></div>
      <div class="pageBox" >
         <div class="content">
            <fb:like href="http://www.facebook.com/apps/application.php?id=<?php print APP_ID ?>" show_faces="true" width="200" font="tahoma"></fb:like>
<?php
                /**
                 *  content output
                 */
                print $this->vars['content'];
?>
         </div>
         
         <div class="footer" >
            <a href="?mode=impress">Impressum</a> | (c) Kay Schneider Production
         </div>
      </div>




      <!-- add here facebooks js api -->
      <script>
         window.fbAsyncInit = function() {
            FB.init({appId: '<?php print APP_ID ?>', status: true, cookie: true,xfbml: true});
            FB.Canvas.setSize({width:700, height:2200});

         };
         (function() {
            var e = document.createElement('script'); e.async = true;
            e.src = document.location.protocol +
               '//connect.facebook.net/de_DE/all.js';
            document.getElementById('fb-root').appendChild(e);
            FB.Canvas.setSize({width:700, height:2300});
         }());
      </script>



   </body>
</html>
