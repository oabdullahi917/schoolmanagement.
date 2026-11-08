<?php
$hash = password_hash('admin123', PASSWORD_DEFAULT);
echo "<pre>Hash: $hash\n\n";
echo "Run this SQL:\n";
echo "UPDATE users SET password = '$hash' WHERE username = 'admin';\n</pre>";
?>