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

$userid = $_POST['userid'];
$quote = $_POST['quote'];
$author = $_POST['author'];
$imageTempName = $_FILES["uploaded_file"]["name"]; // The file name
//upload image and check for image type
//make sure to change your path to match your images directory
$ImageDir = "quoteimages/";
$ImageName = $ImageDir . $imageTempName;
if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$ImageName)) 
{
//get info about the image being uploaded
list($width, $height, $type, $attr) = getimagesize($ImageName);
if ($type > 3)
{
    echo "Sorry. Not jpg, png or gif";
}   
else
{
    

    //insert info into image table
    $stmt = $dbh->prepare("INSERT INTO userquotes (quoteuid, quote, author) 
                    VALUES (?,?,?)");
    $stmt->execute(array($userid, $quote, $author));
    $lastInsertId = $dbh->lastInsertId();

    $newFileName = $ImageDir . $lastInsertId . ".jpg";

    if ($type == 2)
    {
       rename($ImageName, $newFileName); 
    }
    else 
    {
        if ($type == 1)
        {
            $ImageOld = imagecreatefromgif($ImageName);
        }
        else if ($type == 3)
        {
            $ImageOld = imagecreatefrompng($ImageName);
        }
        //convert to jpg
        $image_jpg = imagecreatetruecolor($width, $height);
        imagecopyresampled($image_jpg, $ImageOld, 0, 0, 0, 0,
        $width, $height, $width, $height);
        imagejpeg($image_jpg, $newFileName);
        imagedestroy($image_old);
        imagedestroy($image_jpg);
    }
    $url = "promote_quote.php?id=".$lastInsertId;
    header("Location: $url");
    }
}






