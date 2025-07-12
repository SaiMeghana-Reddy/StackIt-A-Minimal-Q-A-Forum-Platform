```php
<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: You must be logged in to submit a question.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $tags = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate inputs
    if (empty($title) || empty($description) || empty($tags)) {
        echo "Error: All fields are required.";
        exit();
    }

    try {
        $sql = "INSERT INTO questions (user_id, title, description, tags) VALUES (:user_id, :title, :description, :tags)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'tags' => $tags
        ]);
        echo "success";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
```