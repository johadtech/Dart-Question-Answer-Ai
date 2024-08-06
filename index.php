<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ask a Question</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Ask a Question</h1>
        <form action="response.php" method="post">
            <label for="question" class="block text-sm font-medium text-gray-700">Your Question:</label>
            <textarea id="question" name="question" rows="4" class="block w-full p-2 border border-gray-300 rounded mt-1 mb-4" required></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Ask</button>
        </form>
    </div>
</body>
</html>
