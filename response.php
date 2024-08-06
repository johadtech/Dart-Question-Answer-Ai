<?php
require 'vendor/autoload.php';

use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\LanguageServiceClient;
use Smalot\PdfParser\Parser;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];  // Retrieve the user's question from the form input

    putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/your-service-account-file.json');
    $languageServiceClient = new LanguageServiceClient();

    $parser = new Parser();
    $uploadDirectory = 'uploads/';
    $pdfFiles = glob($uploadDirectory . '*.pdf');
    
    // Start the content with the user's question
    $content = $question . "\n\n";  // Include the user's question in the content

    foreach ($pdfFiles as $pdfFile) {
        $pdf = $parser->parseFile($pdfFile);
        $content .= $pdf->getText() . "\n\n";  // Append the text of each PDF file to the content
    }

    $document = new Document([
        'content' => $content,  // The content includes the user's question and the PDF text
        'type' => Document\Type::PLAIN_TEXT,
    ]);

    $response = $languageServiceClient->analyzeEntities($document);
    $entities = $response->getEntities();

    $answer = 'Sorry, I could not find an answer to your question.';
    foreach ($entities as $entity) {
        if (stripos($entity->getName(), $question) !== false) {
            $answer = $entity->getName();  // Find an entity that matches the user's question
            break;
        }
    }

    $languageServiceClient->close();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Your Answer</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4">Your Answer</h1>
            <p class="mb-4"><?php echo htmlspecialchars($answer); ?></p>
            <a href="index.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Ask another question</a>
        </div>
    </body>
    </html>
    <?php
}
?>
