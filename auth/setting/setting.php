<?php
// session_start();
// 1=bangla  // 2=english  // 3=arabic
$setLangage = $_SESSION['setLangage'] = '1';

if ($setLangage == '1') {
    $_SESSION['laguages'] = 'bangla';
} elseif ($setLangage == '2') {
    $_SESSION['laguages'] = 'english';
} elseif ($setLangage == '3') {
    $_SESSION['laguages'] = 'arabic';
}
require_once "languages/" . $_SESSION['laguages'] . ".php";
?>