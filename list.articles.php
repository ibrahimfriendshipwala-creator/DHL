<?php
include 'db.php';
$result = $conn->query("SELECT articles.id, articles.title, categories.name AS category, articles.created_at 
                        FROM articles 
                        LEFT JOIN categories ON articles.category_id = categories.id 
                        ORDER BY articles.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Articles - DHL News</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
    h2 { text-align: center; color: #d60000; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th { background: #d60000; color: white; }
    tr:hover { background-color: #f1f1f1; }
    a.btn {
      padding: 6px 10px;
      background: #d60000;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 14px;
    }
    a.btn:hover { background: #b80000; }
  </style>
</head>
<body>

  <h2>All Articles</h2>

  <table>
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Category</th>
      <th>Created At</th>
      <th>Actions</th>
    </tr>

    <?php
    $i = 1;
    while ($row = $result->fetch_assoc()) {
      echo "<tr>
              <td>{$i}</td>
              <td>{$row['title']}</td>
              <td>{$row['category']}</td>
              <td>{$row['created_at']}</td>
              <td>
                <a href='edit.article.php?id={$row['id']}' class='btn'>Edit</a> 
                <a href='delete.article.php?id={$row['id']}' class='btn'>Delete</a>
              </td>
            </tr>";
      $i++;
    }
    ?>
  </table>

</body>
</html>
