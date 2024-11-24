<?php
session_start();
session_destroy(); // Destroy all sessions
header("Location: /"); // Redirect to home.php
exit();
