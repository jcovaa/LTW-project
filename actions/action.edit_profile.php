<?php
declare(strict_types = 1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/session.php';
require_once __DIR__ . '/../database/user.class.php';

$session = Session::getInstance();
$db = getDatabaseConnection();


if (!$session->validateCSRFToken($_POST['csrf'] ?? '')) {
    $session->addMessage('error', 'Invalid CSRF token.');
    header('Location: ../edit_profile.php');
    exit();
}

// check if user is logged in
$userId = $session->getUserId();
if (!$userId) {
    $session->addMessage('error', 'You must be logged in to edit your profile.');
    header('Location: ../login.php');
    exit();
}

$user = User::getUser($db, $userId);

$name = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');

// check if empty
if (empty($name) || empty($username)) {
    $session->addMessage('error', 'Name and username cannot be empty.');
    header('Location: ../edit_profile.php');
    exit();
}

// profile picture upload
$imagePath = $user->imageUrl; // default to current
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../images/profiles/';
    $fileTmp = $_FILES['profile_picture']['tmp_name'];
    $fileName = basename($_FILES['profile_picture']['name']);
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
        $newFileName = uniqid('img_') . '.' . $extension;
        $destination = $uploadDir . $newFileName;
        if (move_uploaded_file($fileTmp, $destination)) {
            $imagePath = 'images/profiles/' . $newFileName;
        } else {
            $session->addMessage('error', 'Failed to upload profile picture.');
            header('Location: ../edit_profile.php');
            exit();
        }
    } else {
        $session->addMessage('error', 'Invalid image format.');
        header('Location: ../edit_profile.php');
        exit();
    }
}

// Update the user in the DB
$stmt = $db->prepare('UPDATE User SET Name = ?, Username = ?, ImageUrl = ? WHERE UserId = ?');
$stmt->execute([$name, $username, $imagePath, $userId]);

$session->addMessage('success', 'Profile updated successfully.');
header('Location: ../profile.php');
exit();
