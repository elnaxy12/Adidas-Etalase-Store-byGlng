<?php
session_start();
session_destroy(); // Hapus semua data session
header("Location: signup.html?error=notaddemail");
exit;
?>