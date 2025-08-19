<?php
// DEBUG: set to false on production
$debug = true;

// include DB connection (make sure db.php exists and credentials are correct)
include 'db.php';

// Query — use columns that exist in your SQL (id, title, content, created_at, category_id)
$sql = "SELECT a.id, a.title, a.content, a.created_at, 
               IFNULL(c.name, 'Uncategorized') AS category
        FROM articles a
        LEFT JOIN categories c ON a.category_id = c.id
        ORDER BY a.created_at DESC
        LIMIT 6";

$result = $conn->query($sql);

if (!$result) {
    // Friendly error page for developers
    if ($debug) {
        $err = $conn->error;
        echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Query error</title>
              <style>body{font-family:Arial;padding:30px;background:#f9f9f9} .box{background:#fff;padding:20px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.08)}</style>
              </head><body><div class='box'><h2>Database query error</h2>
              <p><strong>Error:</strong> " . htmlspecialchars($err) . "</p>
              <p>Check your <code>articles</code> table columns (expected: id,title,content,category_id,created_at).</p>
              </div></body></html>";
    } else {
        // generic
        http_response_code(500);
        echo "Internal Server Error";
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>DHL News - Breaking Headlines</title>
  <style>
    *{box-sizing:border-box}
    body{font-family:Segoe UI, Roboto, Arial, sans-serif;margin:0;background:#f4f4f4;color:#222}
    header{background:#d60000;color:#fff;padding:22px 24px;text-align:center;font-size:24px;font-weight:700}
    .topbar{display:flex;justify-content:center;gap:12px;padding:12px;background:#111}
    .topbar a{color:#fff;text-decoration:none;padding:8px 12px;border-radius:6px;cursor:pointer}
    .topbar a:hover{background:#222}
    .wrap{max-width:1200px;margin:28px auto;padding:0 18px}
    .grid{display:grid;grid-template-columns:2fr 1fr;gap:20px}
    @media (max-width:900px){ .grid{grid-template-columns:1fr} }
    .main{display:grid;gap:18px}
    .featured{
      background:#fff;padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(0,0,0,.06)
    }
    .cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;margin-top:6px}
    .card{background:#fff;padding:14px;border-radius:10px;box-shadow:0 6px 14px rgba(0,0,0,.05);transition:transform .15s}
    .card:hover{transform:translateY(-6px)}
    .card h3{margin:6px 0 8px;color:#d60000;font-size:18px}
    .meta{font-size:13px;color:#777}
    .excerpt{margin:10px 0 0;color:#333;font-size:14px}
    .read{display:inline-block;margin-top:10px;color:#d60000;font-weight:700;text-decoration:none}
    .sidebar{display:flex;flex-direction:column;gap:16px}
    .box{background:#fff;padding:14px;border-radius:10px;box-shadow:0 6px 14px rgba(0,0,0,.04)}
    .footer{margin-top:24px;padding:18px;text-align:center;color:#fff;background:#111;border-top:4px solid #d60000}
    .clickable{cursor:pointer}
  </style>
  <script>
    function goToArticle(id){
      // JS-based navigation (no PHP redirects)
      if(!id) return;
      window.location.href = 'article.php?id=' + encodeURIComponent(id);
    }
    function goToCategory(cat){
      if(!cat) return;
      window.location.href = 'category.php?cat=' + encodeURIComponent(cat);
    }
  </script>
</head>
<body>

<header>📰 DHL News — Breaking Headlines</header>

<div class="topbar">
  <a onclick="goToCategory('world')">World</a>
  <a onclick="goToCategory('sports')">Sports</a>
  <a onclick="goToCategory('technology')">Technology</a>
  <a onclick="goToCategory('entertainment')">Entertainment</a>
  <a href="add.article.php" style="background:#d60000;color:#fff;border-radius:6px;padding:8px 12px">+ Add Article</a>
</div>

<div class="wrap">
  <div class="grid">
    <div class="main">
      <?php
        // If no rows, show a placeholder
        if ($result->num_rows === 0) {
          echo "<div class='featured box'><h2>No articles found</h2><p>Add articles via <a href='add.article.php'>Add Article</a>.</p></div>";
        } else {
          // First row as a large featured card
          $first = $result->fetch_assoc();
          if ($first) {
            $title = htmlspecialchars($first['title']);
            $content = htmlspecialchars($first['content']);
            $created = $first['created_at'] ? date('M d, Y', strtotime($first['created_at'])) : '';
            $category = htmlspecialchars($first['category']);
            $excerpt = (strlen($content) > 220) ? substr($content,0,220).'...' : $content;
            echo "<div class='featured box clickable' onclick='goToArticle(" . intval($first['id']) . ")'>
                    <div class='meta'>{$category} · {$created}</div>
                    <h2 style='color:#d60000;margin-top:8px'>{$title}</h2>
                    <p style='font-size:15px;margin-top:8px'>{$excerpt}</p>
                    <a class='read' onclick=\"event.stopPropagation();\" href='article.php?id=" . intval($first['id']) . "'>Read full article →</a>
                  </div>";
          }

          // The remaining rows (cards)
          echo "<div class='cards'>";
          // fetch remaining rows
          while ($row = $result->fetch_assoc()) {
            $id = intval($row['id']);
            $title = htmlspecialchars($row['title']);
            $content = htmlspecialchars($row['content']);
            $created = $row['created_at'] ? date('M d, Y', strtotime($row['created_at'])) : '';
            $category = htmlspecialchars($row['category']);
            $excerpt = (strlen($content) > 120) ? substr($content,0,120).'...' : $content;

            echo "<div class='card clickable' onclick='goToArticle($id)'>
                    <div class='meta'>{$category} · {$created}</div>
                    <h3>{$title}</h3>
                    <div class='excerpt'>{$excerpt}</div>
                    <a class='read' onclick=\"event.stopPropagation();\" href='article.php?id={$id}'>Read more →</a>
                  </div>";
          }
          echo "</div>"; // .cards
        }
      ?>
    </div>

    <aside class="sidebar">
      <div class="box">
        <h4 style="margin:0 0 8px 0;color:#d60000">Trending</h4>
        <p style="margin:0">Placeholder trending list. You can populate this dynamically from views or comments.</p>
      </div>

      <div class="box">
        <h4 style="margin:0 0 8px 0;color:#d60000">Search</h4>
        <form method="GET" action="search.php" onsubmit="/* standard GET search to search.php */">
          <input type="text" name="q" placeholder="Search articles..." style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc">
          <button type="submit" style="margin-top:8px;width:100%;padding:8px;background:#d60000;color:#fff;border:none;border-radius:6px">Search</button>
        </form>
      </div>
    </aside>
  </div>

  <div class="footer">
    &copy; <?php echo date('Y'); ?> DHL News — All rights reserved.
  </div>
</div>

</body>
</html>
