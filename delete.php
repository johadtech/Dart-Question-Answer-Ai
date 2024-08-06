<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: admin.php');
    exit();
}

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = 'uploads/' . $file;

    if (file_exists($filePath)) {
        unlink($filePath);
        header('Location: admin.php');
        exit();
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
?>
