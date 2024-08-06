<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf'])) {
    $uploadDirectory = 'uploads/';
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileTmpPath = $_FILES['pdf']['tmp_name'];
    $fileName = $_FILES['pdf']['name'];
    $fileSize = $_FILES['pdf']['size'];
    $fileType = $_FILES['pdf']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    $allowedfileExtensions = array('pdf');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $dest_path = $uploadDirectory . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Upload Success</title>
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            </head>
            <body class="bg-gray-100 flex items-center justify-center min-h-screen">
                <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
                    <h1 class="text-2xl font-bold mb-4">Upload Success</h1>
                    <p>The file <?php echo htmlspecialchars($fileName); ?> has been uploaded successfully.</p>
                    <a href="admin.php" class="block mt-4 text-blue-500 hover:underline">Back to Dashboard</a>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "There was an error moving the uploaded file.";
        }
    } else {
        echo "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
    }
} else {
    echo "No file uploaded or invalid request.";
}
?>
