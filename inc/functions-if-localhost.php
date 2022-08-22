<?php
################### Function to check if it's locahost (bool)
function isLocalhost($whitelist = ['127.0.0.1', '::1']) { return (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) ? true : false; }
?>