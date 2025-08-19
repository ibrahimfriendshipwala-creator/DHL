<?php
include 'db.php';

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = trim($_POST['category']);

    if (!empty($category)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $category);
        if ($stmt->execute()) {
            echo "<script>alert('Category added successfully!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Category already exists or error occurred.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Category - DHL News</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
    .form-box {
      background: white;
      max-width: 400px;
      margin: auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 { color: #d60000; text-align: center; }
    label { display: block; margin-top: 15px; }
    input[type="text"] {
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

  <div class="form-box">
    <h2>Add New Category</h2>
    <form method="POST">
      <label>Category Name</label>
      <input type="text" name="category" required placeholder="e.g. Politics">
      <button type="submit">Add Category</button>
    </form>
  </div>

</body>
</html>
