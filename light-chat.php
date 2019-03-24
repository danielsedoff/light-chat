<?php

/* Disable HTTP, HTTPS only. Please enable if applicable.
---------------------------------------------------------
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
*/

$die_header = "<" . "?php die(); ?" . ">\n";
$die_length = strlen($die_header);

function undead($who) {
    global $die_length;
    return (substr($who, $die_length));
}

?>

<html><head><meta charset="utf-8">
<script>

var timerId = setInterval(periodicFunction, 2000);

function periodicFunction() {

    var xhr = new XMLHttpRequest();
    
    inTxt = document.getElementById("inTxt");
    if (document.getElementById("pass").value == "") { inTxt.value = "Please input password"; return; }
    inVal = inTxt.value;
    
    var st = 'pass=' + encodeURIComponent(document.getElementById("pass").value);
    st += '&lastline=' + encodeURIComponent(lastline(inVal));
    
    xhr.open("POST", 'read.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function(){
        inTxt = document.getElementById("inTxt");
        respTxt = xhr.responseText; // console.log("resp:" + respTxt);
        if(respTxt == "") {
            respTxt = "(empty)";
        } else if (respTxt.substring(0, 1) == "Z") {
            /* Zero change */
        } else if(respTxt == "C") {
            /* C for Clear */
            inTxt.value = "";
        } else if(respTxt.substring(0, 1) == "A") {
            /* A for Add */ 
            inTxt.scrollTop = inTxt.scrollHeight;
            
            inTxt.value = respTxt.substring(1); 
            flashInTxtColor();
        } else if(respTxt.substring(0, 1) == "B") {
            /* B - add to bottom */
            inTxt.scrollTop = inTxt.scrollHeight;


            if(inTxt.value.indexOf(respTxt.substring(1)) == -1) { 
             inTxt.value += "" + respTxt.substring(1);
             /* Avoid doubles */
            }
            flashInTxtColor();
console.log("resptxt>" + respTxt);
        }
    };
    xhr.send(st);
}

function flashInTxtColor()
{
    inTxt = document.getElementById("inTxt");
    
    document.title = "********" + document.title;
    inTxt.style.backgroundColor = "gray";
    
    temp142 = setTimeout(function(){ 

        inTxt = document.getElementById("inTxt");
        inTxt.style.backgroundColor = null;
        document.title = document.title.substring(8);

    }, 1000);  
}

function togglePass(){
    var v = document.getElementById("passLabel").style.visibility;
    v = (v == "visible") ? "hidden" : "visible";
    document.getElementById("passLabel").style.visibility = v;
    document.getElementById("passInput").style.visibility = v;
}

document.onkeydown = function(evt) {
    var evt = evt || window.event;
    if (evt.keyCode != 13) return; 
    sendMsg();
};

function sendMsg(){
    var outTxt = document.getElementById("outTxt");
    var passTx = document.getElementById("pass");
    if (outTxt.value.length <= 0) return;

    var xhr = new XMLHttpRequest();
    var st = 'pass=' + encodeURIComponent(passTx.value);
    st += '&msg=' + encodeURIComponent(outTxt.value);
    xhr.open("POST", 'write.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function(){ 
        outTxt.value = "";
    };
    xhr.send(st);
}

function clearChat(){
    outTxt = document.getElementById("outTxt");
    outTxt.value = "CLEAR_THIS_CHAT_NOW";
    sendMsg();
}

function lastline(ofwhat){
    ar = ofwhat.split("\n");
    ln = ar.length;
    if(ar[ln - 1] == "") --ln;
    return(ar[ln-1]);
}

</script>

<style>
    .inlineForm {
        display:inline;
    }
    
</style>

<!-- TODO
    +чтобы clear не сбрасывал пароль и имя
    +автопрокрутка вниз к новым сообщениям или добавка сверху
    +отправка по ENTER
    +уходит курсор из окна набора
    +убрать поле NAME
    +сделать шрифты для мобилы
    +авторефреш
    -вывести в отдельную страницу поле PASS и change pass
-->


</head><body>
<form class="inlineForm" name="light-chat" method="post" action="">
    
<textarea style="width: 100%; height: 60%; font-size: 32px;" id="inTxt" readonly></textarea>

    <textarea id="outTxt" name="2" style="width: 100%; height: 20%;  font-size: 32px;" autofocus></textarea>
    <input type="button" value="ENTER" style="font-size: 32px;" onclick="sendMsg();">
    
    <span style="font-size: 32px;">
        <span onclick="togglePass()">PASS:</span>
        <input type="password" id="pass" name="p" style="width: 250px; font-size: 32px;"
        value="<?php if($_POST!=null) echo $_POST["p"]; ?>">
        </input>
        <span id="passLabel">
        <input type="button" style="font-size: 32px;" onclick="window.location.href='change-pass.php';" value="CHANGE PASS"/>
        </span>
    </span>
</form>

<input type="BUTTON" value="CLEAR CHAT" style="font-size: 32px;" onclick="clearChat()">

</body></html>
