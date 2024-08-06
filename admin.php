<?php
session_start();

$adminUsername = 'admin';
$adminPassword = 'adminpassword';
$encodedPassword = base64_encode($adminPassword);

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    displayAdminPage();
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username === $adminUsername && base64_encode($password) === $encodedPassword) {
            $_SESSION['authenticated'] = true;
            displayAdminPage();
        } else {
            displayLoginPage('Invalid credentials, please try again.');
        }
    } else {
        displayLoginPage();
    }
}

function displayLoginPage($error = '') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4">Admin Login</h1>
            <?php if ($error): ?>
                <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="admin.php" method="post">
                <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                <input type="text" id="username" name="username" class="block w-full p-2 border border-gray-300 rounded mt-1 mb-4" required>
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" id="password" name="password" class="block w-full p-2 border border-gray-300 rounded mt-1 mb-4" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
}

function displayAdminPage() {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="pdf" class="block text-sm font-medium text-gray-700">Upload PDF:</label>
                <input type="file" id="pdf" name="pdf" accept="application/pdf" class="block w-full p-2 border border-gray-300 rounded mt-1 mb-4" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Upload</button>
            </form>
            <h2 class="text-xl font-bold mt-6 mb-4">Available PDFs</h2>
            <ul>
                <?php
                $uploadDirectory = 'uploads/';
                $pdfFiles = glob($uploadDirectory . '*.pdf');
                foreach ($pdfFiles as $pdfFile) {
                    $fileName = basename($pdfFile);
                    echo "<li class='mb-2'>$fileName <a href='delete.php?file=$fileName' class='text-red-500 hover:underline ml-2'>Delete</a></li>";
                }
                ?>
            </ul>
            <a href="logout.php" class="block mt-4 text-blue-500 hover:underline">Logout</a>
        </div>
    </body>
    </html>
    <?php
}
?>
