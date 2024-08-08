<?php
$host = 'localhost';
$db = 'feedback_survey';
$user = 'root'; // Change this to your MySQL username
$pass = ''; // Change this to your MySQL password

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
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

        $stmt = $pdo->prepare("INSERT INTO feedback (name, email, age, document, feedback_type, services, comments) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $age, $document, $feedback_type, $services, $comments]);
    }

    // Update operation
    if (isset($_POST['update'])) {
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
    }

    // Delete operation
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM feedback WHERE id=?");
        $stmt->execute([$id]);
    }
}

$feedbacks = $pdo->query("SELECT * FROM feedback")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Survey Form</title>
</head>
<body>
    <h1>Feedback Survey Form</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label>Name: <input type="text" name="name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Age: <input type="number" name="age" required></label><br>
        <label>Document: <input type="file" name="document"></label><br>
        <label>Type of feedback:
            <select name="feedback_type" required>
                <option value="Positive">Positive</option>
                <option value="Negative">Negative</option>
            </select>
        </label><br>
        <label>Service used:
            <input type="checkbox" name="services[]" value="Service1"> Service1
            <input type="checkbox" name="services[]" value="Service2"> Service2
            <input type="checkbox" name="services[]" value="Service3"> Service3
        </label><br>
        <label>Additional comments: <textarea name="comments"></textarea></label><br>
        <button type="submit" name="submit">Submit Feedback</button>
    </form>

    <h2>Feedback List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Document</th>
                <th>Type</th>
                <th>Service</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($feedbacks as $feedback): ?>
                <tr>
                    <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['age']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['document']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['feedback_type']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['services']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['comments']); ?></td>
                    <td>
                        <form action="index.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $feedback['id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                        <form action="edit.php" method="get" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $feedback['id']; ?>">
                            <button type="submit">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>