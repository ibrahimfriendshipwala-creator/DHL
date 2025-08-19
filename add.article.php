<?php
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category'];
    $author = $_POST['author'];

    $stmt = $conn->prepare("INSERT INTO articles (title, content, category_id, author) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $content, $category_id, $author);
    $stmt->execute();

    echo "<script>alert('Article added successfully!'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add New Article - DHL News</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
    .form-container {
      background: white;
      padding: 20px;
      max-width: 600px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; color: #d60000; }
    label { display: block; margin-top: 15px; }
    input[type="text"], textarea, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background: #d60000;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background: #b80000;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Add New Article</h2>
    <form method="POST">
      <label>Title</label>
      <input type="text" name="title" required>

      <label>Content</label>
      <textarea name="content" rows="6" required></textarea>

      <label>Author</label>
      <input type="text" name="author" value="Admin" required>

      <label>Category</label>
      <select name="category" required>
        <option value="">-- Select Category --</option>
        <?php
        $result = $conn->query("SELECT id, name FROM categories");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
      </select>

      <button type="submit">Add Article</button>
    </form>
  </div>

</body>
</html>
