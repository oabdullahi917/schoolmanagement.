<?php
// make_user_hashes.php — DELETE THIS FILE AFTER USE
$users = [
    'admin'       => 'admin123',
    'principal'   => 'password123',
    'accountant1' => 'password123',
    'teacher1'    => 'password123',
    'teacher2'    => 'password123',
    'teacher3'    => 'password123',
    'teacher4'    => 'password123',
    'teacher5'    => 'password123',
    'parent1'     => 'password123',
    'parent2'     => 'password123',
    'parent3'     => 'password123',
    'parent4'     => 'password123',
    'parent5'     => 'password123',
    'parent6'     => 'password123',
    'parent7'     => 'password123',
    'parent8'     => 'password123',
    'parent9'     => 'password123',
    'parent10'    => 'password123',
    'student1'    => 'password123',
    'student2'    => 'password123',
    'student3'    => 'password123',
    'student4'    => 'password123',
    'student5'    => 'password123',
    'student6'    => 'password123',
    'student7'    => 'password123',
    'student8'    => 'password123',
    'student9'    => 'password123',
    'student10'   => 'password123',
];

echo "<pre style='font-family:monospace;font-size:12px;padding:20px;background:#f4f4f4'>";
echo "Run this SQL in phpMyAdmin:\n\n";

foreach ($users as $username => $plain) {
    $hash = password_hash($plain, PASSWORD_DEFAULT);
    echo "UPDATE users SET password = '$hash' WHERE username = '$username';\n";
}

echo "\n\n-- DELETE THIS FILE AFTER RUNNING THE SQL --";
echo "</pre>";

?>