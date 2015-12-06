<?php

session_start();
$uid = $_SESSION['uid'];
$login = $_SESSION['login'];
if (!is_numeric($uid) || !isset($login))
{
    header('Location: login.php');
}

require 'configurations/dbconnector.php';
include 'configurations/error_reporting.php';
$id = $_GET['id'];

//**INSERT THE FOLLOWING LINE:
if (isset($_REQUEST['mode'])) 
{
    $mode = $_REQUEST['mode'];
}
else
{
    $mode = '';
}


?>



<html>
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow" />
    <link rel="alternate" href="" hreflang="en-us" />
    <meta name="google-site-verification" content="" />
    <meta name="p:domain_verify" content=""/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css"
    rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="yeti/theme/christopher.css">
    <link rel="stylesheet" href="yeti/theme/bootstrap.css" media="screen">
    <!--<link rel="stylesheet" href="yeti/theme/usebootstrap.css">-->
    <link rel="stylesheet" href="yeti/theme/usebootstrap.less">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <style>h1, h2, h3, h4, h5, p, i, a {font-family: 'Open Sans', sans-serif;}</style>
    <link rel="stylesheet" href="sweetalert/dist/sweetalert.css">
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-XXXXXX-Y', 'auto');
      ga('send', 'pageview');

    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script>
    $(document).ready(function() {
      $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
    });
    </script>
    <script>
    $(document).ready(function() {

        $('#quoteloader').submit(function() {    //start prevent empty form being submitted
            if ($.trim($('#quote').val()) == '') {
                sweetAlert("Oops...", "You have no quote to submit!", "error");
                return false;
            }

        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){

    //Check if the current URL contains '#'
    if(document.URL.indexOf("#")==-1)
    {
    // Set the URL to whatever it was plus "#".
    url = document.URL+"#";
    location = "#";

    //Reload the page
    location.reload(true);

    }
    });
    </script>
  </head> 
  <body>     
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="page-header">
                <h1>Add quote<br>
                <small>create your own quote which will be shared with others!</small>
              </h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    
          <div class="col-md-8">
              <?php
              $dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
              
                $sql = "SELECT id, quoteuid, quote FROM userquotes WHERE id = '$id' AND quoteuid = '$uid'";
                $stmt = $dbh->query($sql);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $quoteid = $row['quoteuid'];
                $quote = strip_tags($row['quote']);
                //echo $id;
                $imageFileName = "quoteimages/".$id.".jpg";
                list($width, $height, $type, $attr) = getimagesize($imageFileName);
                if ($mode == 'change')
                {
                    echo "<img src='$imageFileName' class='img-responsive' alt='$quote'>";
                }
                else
                {
                ?>    
            
            <img src="<?php echo $imageFileName; ?>" class="img-responsive" alt="<?php echo $quote; ?>">
            <br>
            <strong><?php echo $quote; ?></strong><br>
            <p><em><strong>Choose a filter for the image</strong></em></p>
            <p class="text-danger">Choose 1 filter - not all simultaneously</p>
            <form action="modifyimage.php" method="post">
                <input name="id" type="hidden" value="<?php echo $id; ?>">
                <input name="bw" type="checkbox">grey scale<br>
                <input name="sep" type="checkbox">sepia<br>
                <input name="negate" type="checkbox">negative<br>
                <input name="brighten" type="checkbox">brighten<br>
                <input name="contrast" type="checkbox">contrast<br>
                <input name="blur" type="checkbox">blur<br>
                <input name="smooth" type="checkbox">smooth<br>
                <input name="edge" type="checkbox">edge detect<br>
                <input name="emboss" type="checkbox">emboss<br>
                <input type="hidden" name="text" value="<?php echo $quote; ?>"><br>
                <p align="center">
                <input type="submit" name="action" class="btn btn-primary btn-sm" value="preview">
                <input type="submit" name="action" class="btn btn-success btn-sm" value="save">
                </p>
            </form>
            <?php
            }
            ?>
            
            <br><br>
            
            <hr>
               <?php
                if (isset($_GET['mode']) && ($_GET['mode']) == 'change')
                {
                    ?>
                <ul class="list-inline">
                    
                    <!--important! you need this pinterest button. Go Pinterest and create one-->  
                    <li>Now Pin your image <a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"  data-pin-round="true" data-pin-tall="true"><img src="// assets.pinterest.com/images/pidgets/pinit_fg_en_round_red_32.png" /></a></li>
                    <br><li>Or right click on the image to download and share to Instagram, Twitter and Facebook</li>
                    <!-- Please call pinit.js only once per page -->
                    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
                </ul>
                <?php
                }
                else 
                {
                    //nothing
                }
               ?>
            <br>
          </div>
        </div>
      </div>
    </div>
<!-- Boostrap javascript -->
<script src="javascript/bootstrap.js"></script>
<script src="javascript/bootstrap.min.js"></script>
<script src="npm.js"></script>
  </body>

</html>
