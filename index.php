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

?>


<html>
  
  <head>
    <meta charset="utf-8">
    <!--optimize for SEO-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow" />
    <link rel="alternate" href="" hreflang="en-us" />
    <meta name="google-site-verification" content="" />
    <meta name="p:domain_verify" content=""/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!--you may use any bootrap theme
    link to this theme http://bootswatch.com/yeti/bootstrap.min.css-->
    <link rel="stylesheet" href="yeti/theme/christopher.css">
    <link rel="stylesheet" href="yeti/theme/bootstrap.css" media="screen">
    <!--<link rel="stylesheet" href="yeti/theme/usebootstrap.css">-->
    <link rel="stylesheet" href="yeti/theme/usebootstrap.less">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'> 
    <style>h1, h2, h3, h4, h5, p, i, a {font-family: 'Open Sans', sans-serif;}</style>
    <link rel="stylesheet" href="sweetalert/dist/sweetalert.css">
    
    <script>
    //analytics code
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-XXXXXXXX-Y', 'auto');
	  ga('send', 'pageview');

    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet" type="text/css">
    
    <!--tiny mce
    download from https://www.tinymce.com/-->
    <script src="blog/tinymce/jquery-1.11.3.min.js"></script>
    <script src="blog/tinymce/tinymce.min.js"></script>

    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            theme: "modern",
            plugins: [
                "advlist lists",
                "searchreplace visualblocks fullscreen",
                "contextmenu"   
            ],
            toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
            skin: "xenmce",
            relative_urls: false

        });
    </script>
    <!--sweetalert
    download from http://t4t5.github.io/sweetalert/-->
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
    //sweetalert error message
    $(document).ready(function() {
        $('#quoteloader').submit(function() {    //start prevent empty form being submitted
            if ($.trim($('#quote').val()) == '') {
                sweetAlert("Oops...", "You have no quote to submit! Try once more it should work!", "error");
                return false;
            }

        });
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
                    <small>Create your own quote which will be shared with others!<br>
                    Earn points for each quote you add!</small>
              </h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    
          <div class="col-md-4">
             
              
            
              <form action="check_image.php" method="post" id="quoteloader" enctype="multipart/form-data" onsubmit="myFunction()">     
                  <div class="form-group">
                  <input type="file" name="uploaded_file" id="uploaded_file">
              </div>
              <div class="form-group">
                  <label class="control-label" for="quote">Your quote <small>140 characters maximum</small></label>
                  <textarea class="form-control" rows="2" name="quote" id="quote"></textarea>
               <br>
              </div>
              <input type="hidden" name="userid" value="<?php echo $uid; ?>">
              <input type="hidden" name="author" value="<?php echo $login; ?>">
              <input type="submit" name="submit" class="btn btn-success btn-sm" value="Add quote">
              <input type="reset" name="reset" class="btn btn-default btn-sm" value="Clear form">
            </form>
                <script>
                //capture textarea input onsubmit.
                function myFunction()
                {
                    tinymce.get('quote').save();
                    
                }
              </script>
          </div>
            <div class="col-md-4">
                <div class="alert alert-danger">
                
                    <span class="fa fa-hand-o-right"></span> <strong>Tips for sharing your quote</strong>
                    <hr class="message-inner-separator">
                    <ul class="list-unstyled">
                        <li>Keep the image width around 740px</li>
                        <li>Your image may be png, jpg or gif</li>
                        <li>Ensure your image obeys copyright law</li>
                        <li>Create your own quote</li>
                        <li>Do not copy quotes from the internet</li>
                        <li>Format your quote as in the image below</li>
                    </ul>
                </div>
                <img class="img-thumbnail img-responsive" src="img/tooltipquote.png"
                              alt="Do not take quotes from the internet. Create your own quotes.">  
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
