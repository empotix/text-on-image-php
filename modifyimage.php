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

$dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
$id = $_POST['id'];
if (isset($_POST['bw']))
{
    $bw = $_POST['bw'];
}
else
{
    $bw = '';
}

if (isset($_POST['sep']))
{
    $sep = $_POST['sep'];
}
else
{
    $sep = '';
}

if (isset($_POST['negate']))
{
    $negate = $_POST['negate'];
}
else
{
    $negate = '';
}

if (isset($_POST['brighten']))
{
    $brighten = $_POST['brighten'];
}
else
{
    $brighten = '';
}

if (isset($_POST['contrast']))
{
    $contrast = $_POST['contrast'];
}
else
{
    $contrast = '';
}

if (isset($_POST['blur']))
{
    $blur = $_POST['blur'];
}
else
{
    $blur = '';
}

if (isset($_POST['smooth']))
{
    $smooth = $_POST['smooth'];
}
else
{
    $smooth = '';
}

if (isset($_POST['edge']))
{
    $edge = $_POST['edge'];
}
else
{
    $edge = '';
}

if (isset($_POST['emboss']))
{
    $emboss = $_POST['emboss'];
}
else
{
    $emboss = '';
}

$action = $_POST['action'];
//**INSERT THE FOLLOWING LINES:
if (isset($_POST['text'])) 
{
$text = $_POST['text'];
} 
else 
{
$text = '';
}
//**END OF INSERT
//i removed url on 24 novenber 2015
$sql = "SELECT id, quoteuid, quote FROM userquotes WHERE id = '$id' AND quoteuid = '$uid'";
$stmt = $dbh->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$id = $row['id'];
$quoteid = $row['quoteuid'];
$quote = strip_tags($row['quote']);
$imageFileName = "quoteimages/".$id.".jpg";
list($width, $height, $type, $attr) = getimagesize($imageFileName);

$image = imagecreatefromjpeg($imageFileName);

if ($bw == 'on')
{
    imagefilter($image, IMG_FILTER_GRAYSCALE);
}

if ($sep == 'on')
{
    imagefilter($image, IMG_FILTER_COLORIZE,100, 50, 0);
}

if ($negate == 'on')
{
    imagefilter($image, IMG_FILTER_NEGATE);
}

if ($brighten == 'on')
{
    imagefilter($image, IMG_FILTER_BRIGHTNESS, 50);
}

if ($contrast == 'on')
{
    imagefilter($image, IMG_FILTER_CONTRAST, -40);
}

if ($blur == 'on')
{
    imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
}

if ($smooth == 'on')
{
    imagefilter($image, IMG_FILTER_SMOOTH, 50);
}

if ($edge == 'on')
{
    imagefilter($image, IMG_FILTER_EDGEDETECT);
}

if ($emboss == 'on')
{
    imagefilter($image, IMG_FILTER_EMBOSS);
}

if ($text != '')
{
   
    // find font-size for $txt_width = 80% of $img_width...
    $font_size = 20;
    $white = imagecolorallocate($image, 255, 255, 255);
    $font = 'nobile.ttf';
    $txt_max_width = intval(0.8 * $width);    

    do {

        $font_size++;
        $p = imagettfbbox($font_size,0,$font,$quote);
        $txt_width=$p[2]-$p[0];
        $txt_height=$p[1]-$p[7]; // just in case you need it

    } while ($txt_width <= $txt_max_width);

    // now center text...
    $y = $height * 0.2; // baseline of text at 90% of $img_height
    $x = ($width - $txt_width) / 2;
    imagettftext($image, $font_size, 0, $x, $y, $white, "nobile.ttf", $quote);
}

if ($action == 'preview')
{
    header("Content-type:image/jpeg");
    imagejpeg($image);
    
}

if ($action == 'save')
{
    imagejpeg($image, $imageFileName);

    $url = "promote_quote.php?id=".$id."&mode=change";
    header("Location: $url");
}
  



  
