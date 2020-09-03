<?php
session_start();

echo "Welcome". $_SESSION['studentid'].$_SESSION['userType'];

?>