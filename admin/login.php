<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$file_path = __DIR__ . '/login.info';
$file = fopen($file_path, 'r');
$valid = false;

if ($file) {
  $file_username = trim(fgets($file));
  $file_password = trim(fgets($file));
  
  if ($username === explode('=', $file_username)[1] && $password === explode('=', $file_password)[1]) {
    $valid = true;
    $_SESSION['username'] = $username;
  }
  
  fclose($file);
}

$response = [
  'success' => $valid
];

echo json_encode($response);
?>