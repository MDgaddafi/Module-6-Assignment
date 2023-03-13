<?php

// Check if all form fields are filled out
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_FILES['profile_picture'])) {
	die('Error: All form fields are required.');
}

// Validate email format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	die('Error: Invalid email format.');
}

// Save profile picture to server
$uploads_dir = 'uploads/';
$profile_picture = $_FILES['profile_picture'];
$profile_picture_name = uniqid() . '_' . $profile_picture['name'];
$profile_picture_path = $uploads_dir . $profile_picture_name;

if (!move_uploaded_file($profile_picture['tmp_name'], $profile_picture_path)) {
	die('Error: Failed to save profile picture.');
}

// Save user data to CSV file
$user_data = array($_POST['name'], $_POST['email'], $profile_picture_name);
$file = fopen('users.csv', 'a');
fputcsv($file, $user_data);
fclose($file);

// Start session and set cookie
session_start();
setcookie('name', $_POST['name'], time()+3600);

// Redirect to success page
header('Location: success.html');
exit();

?>

