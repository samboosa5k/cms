<?php
$hash = '$2y$10$3X1i3CEqV0y/Q1k8X1MrIuuDvEjED3LJhk8raJN.s3CPV4fEA9ZdK';
$password = 'testpasss';

echo $hash . "<br>";
echo $password . "<br>";
echo password_verify($password, $hash);
