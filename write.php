 <?php

    $CLEAR_DISABLED = false;

    if($_POST == null) die();
    $msg = $_POST["msg"];
    
    $unqn = time() - 1508800300;
    $unqn *= 31;
    $unqn -= 1712345;

    $die_header = "<" . "?php die(); ?" . ">\n";
    $die_length = strlen($die_header);

    function undead($who) {
        global $die_length;
        return (substr($who, $die_length));
    }

    $x = undead(file_get_contents("2.php"));
    if(md5($_POST["pass"]) != $x) { die ("error 2"); }
    
    if($CLEAR_DISABLED == false && $msg == "CLEAR_THIS_CHAT_NOW") {
        file_put_contents("1.php", $die_header);
        die();
    }
    
    $msg_empty = true;
    for($i = 0; $i < strlen($msg); $i++) {
        $x = substr($msg, $i, 1);
        if($x != " " && $x != "\r" && $x != "\n") {
            $msg_empty = false; break;
        }
    }
    if($msg_empty == true) die(); 

    while(strlen($msg) > 1) {
        $lastSymb = substr($msg, strlen($msg) - 1, 1);
        if($lastSymb == "\n" || $lastSymb == "\r" || $lastSymb == " ") {
            $msg = substr($msg, 0, strlen($msg) - 1);
        } else break;
    }
    file_put_contents("1.php", ( $unqn . " : " . $msg . "\n" ), FILE_APPEND | LOCK_EX);
    /* file_put_contents("1.php", $die_header . 
        $unqn . " : " . $msg . "\n" . undead(file_get_contents("1.php"))); */    
    
 ?>
 
