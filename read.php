<?php

$die_header = "<" . "?ph" . "p d" . "ie(); ?" . ">\n";
$die_length = strlen($die_header);

function lastline($ofwhat){

   $tmp = explode("\n", $ofwhat);
   $ln  = count($tmp);
   if($ln < 2) {
    $x = (" ");
   } else {
    $x = ($tmp[$ln - 2]);
   }

   return ($x);
}

function undead($who) {
    global $die_length;
    return (substr($who, $die_length));
}

if($_POST == null) {
 die("APost empty");
}

$usr_pass = $_POST["pass"];

$pass_md5 = undead(file_get_contents("2.php"));
if(md5($usr_pass) != $pass_md5) {
 die ("AWrong pass");
}

if(isset($_POST["lastline"])) {
    $last_line = $_POST["lastline"];
} else {
    $last_line = "";
}

/* DEBUG  echo "Aposted last line [" . $last_line . "]"; */

$post_content = undead(file_get_contents("1.php"));

if($post_content == "" ) {
 die("C"); /* Clear */
}

if($last_line == "" || $last_line == null) {
    die("A" . $post_content); /* Whole file */
}

if(lastline($post_content) == $last_line) {
 die("Z"); /* Zero change */
} else {
 /* Download everything after the posted last line. DO NOT include that line itself */
 $to_send = substr($post_content, strpos($post_content, $last_line) + strlen($last_line) + 1);
 die("B" . $to_send);
}



?>