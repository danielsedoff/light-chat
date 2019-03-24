<?php

    $die_header = "<" . "?php die(); ?" . ">\n";
    $die_length = strlen($die_header);
    function undead($who) {
        global $die_header, $die_length;
        return (substr($who, $die_length));
    }

    if($_POST != null) {
        $x = undead(file_get_contents("2.php"));
        if($_POST["2"] != $_POST["3"])  die("error 1");

        if(md5($_POST["1"]) != $x)      die("error 2");



        file_put_contents("2.php", $die_header . md5($_POST["2"]));
        die("OK");
    }

?>
<html>
<head>
<style> * {font-size: 32px; } </style>
</head>
<body>
<form method="post">
    <table>
    <tr><td>OLD:        </td><td><input type="password" name="1"></td></tr>
    <tr><td>NEW:        </td><td><input type="password" name="2"></td></tr>
    <tr><td>REPEAT: </td><td><input type="password" name="3"></td></tr>
    <tr><td colspan="2"><input type="submit" value="SUBMIT"></td></tr>
    </table>
</form>
</body>
</html>