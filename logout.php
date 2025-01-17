<?php
session_start();
session_destroy(); // Uništavamo sve podatke sesije
header("Location: index.php");
exit;
