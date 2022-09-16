<?php

echo 'HTTP_CF_CONNECTING_IP: ' .  $_SERVER['HTTP_CF_CONNECTING_IP'] . '<br><br>';

echo 'REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR'] . '<br><br>';

// Se preferir usar sempre a variável $_SERVER['REMOTE_ADDR'], você pode verificar e setar antes.
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
	$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}


?>