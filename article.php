<?php $id = $_GET['id']; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Article <?php echo $id; ?> - DHL News</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
    header { background: #d60000; color: white; padding: 20px; text-align: center; }
    .article-container {
      background: white;
      margin: 20px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .article-container h2 { margin-top: 0; }
    .meta-info { font-size: 13px; color: gray; margin-bottom: 20px; }
    .comments {
      margin-top: 40px;
      background: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
    }
    .comments h3 { margin-top: 0; }
    .comment-form textarea {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      resize: vertical;
    }
    .comment-form button {
      margin-top: 10px;
      padding: 10px 15px;
      background: #d60000;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .comment-form button:hover {
      background: #b80000;
    }
  </style>
</head>
<body>

  <header>
    <h1>Full Article View</h1>
  </header>

  <div class="article-container">
    <h2>Headline of Article #<?php echo $id; ?></h2>
    <p class="meta-info">By Admin | August 6, 2025</p>
    <p>
      This is the full content of article #<?php echo $id; ?>. You can replace this text with dynamic data from your database later. 
      The goal here is to demonstrate layout, styling, and internal JS/CSS structure.
    </p>
  </div>

  <div class="article-container comments">
    <h3>Comments</h3>
    <div class="comment-form">
      <textarea placeholder="Write your comment..."></textarea>
      <button type="button">Post Comment</button>
    </div>
  </div>

</body>
</html>
