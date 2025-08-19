<?php $cat = $_GET['cat']; ?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo ucfirst($cat); ?> News - DHL</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
    header { background: #d60000; color: white; padding: 20px; text-align: center; }
    .container { padding: 20px; }
    .news-card {
      background: white;
      margin-bottom: 15px;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .news-card h2 { margin: 0 0 10px; font-size: 18px; }
    .news-card p { font-size: 14px; margin: 0; }
    .read-more { color: #d60000; cursor: pointer; font-weight: bold; }
  </style>
  <script>
    function goToArticle(id) {
      window.location.href = 'article.php?id=' + id;
    }
  </script>
</head>
<body>

  <header>
    <h1><?php echo ucfirst($cat); ?> News</h1>
    <p>Category-specific updates and latest headlines</p>
  </header>

  <div class="container">
    <div class="news-card">
      <h2>Top Story in <?php echo ucfirst($cat); ?></h2>
      <p>This is the main article summary from <?php echo $cat; ?> category... 
        <span class="read-more" onclick="goToArticle(4)">Read more</span>
      </p>
    </div>
    <div class="news-card">
      <h2>Another Highlight in <?php echo ucfirst($cat); ?></h2>
      <p>Breaking development on a related topic... 
        <span class="read-more" onclick="goToArticle(5)">Read more</span>
      </p>
    </div>
  </div>

</body>
</html>
