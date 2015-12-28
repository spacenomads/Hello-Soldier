<?php

$user['pass'] = 'hosita';

function check_logged(){
     global $_SESSION, $user;
     if (!array_key_exists($_SESSION["logged"],$user)) {
          header("Location: login.php");
     };
};
?>
