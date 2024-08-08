<?php
$host = 'localhost';
$db = 'feedback_survey';
$user = 'root'; // Change this to your MySQL username
$pass = ''; // Change this to your MySQL password

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $feedback_type = $_POST['feedback_type'];
    $services = implode(',', $_POST['services']);
    $comments = $_POST['comments'];

    $document = $_FILES['document']['name'];
    if ($document) {
        move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/' . $document);
    }

    $stmt = $pdo->prepare("UPDATE feedback SET name=?, email=?, age=?, document=?, feedback_type=?, services=?, comments=? WHERE id=?");
    $stmt->execute([$name, $email, $age, $document, $feedback_type, $services, $comments, $id]);

    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM feedback WHERE id=?");
$stmt->execute([$id]);
$feedback = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Feedback</title>
</head>
<body>
    <h1>Edit Feedback</h1>
    <form action="edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $feedback['id']; ?>">
        <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($feedback['name']); ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($feedback['email']); ?>" required></label><br>
        <label>Age: <input type="number" name="age" value="<?php echo htmlspecialchars($feedback['age']); ?>" required></label><br>
        <label>Document: <input type="file" name="document"></label><br>
        <label>Type of feedback:
            <select name="feedback_type" required>
                <option value="Positive" <?php if ($feedback['feedback_type'] == 'Positive') echo 'selected'; ?>>Positive</option>
                <option value="Negative" <?php if ($feedback['feedback_type'] == 'Negative') echo 'selected'; ?>>Negative</option>
            </select>
        </label><br>
        <label>Service used:
            <input type="checkbox" name="services[]" value="Service1" <?php if (strpos($feedback['services'], 'Service1') !== false) echo 'checked'; ?>> Service1