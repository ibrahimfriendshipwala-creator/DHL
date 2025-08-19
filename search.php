<?php
include 'db.php';

$searchTerm = '';
$results = [];

if (isset($_GET['q'])) {
    $searchTerm = trim($_GET['q']);
    if (!empty($searchTerm)) {
        $stmt = $conn->prepare("
            SELECT articles.id, articles.title, articles.summary, articles.created_at, categories.name AS category 
            FROM articles
            LEFT JOIN categories ON articles.category_id = categories.id
            WHERE articles.title LIKE ? OR articles.summary LIKE ?
            ORDER BY articles.created_at DESC
        ");
        $like = "%" . $searchTerm . "%";
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $results = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results - DHL News</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #d60000;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .search-bar {
            text-align: center;
            padding: 20px;
        }
        .search-bar input[type="text"] {
            width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .search-bar button {
            padding: 8px 12px;
            background: #d60000;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card h3 {
            margin-top: 0;
            color: #d60000;
        }
        .card a {
            text-decoration: none;
            color: #d60000;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <a href="index.php">🏠 DHL News</a>
    <span>Search Results</span>
</header>

<div class="search-bar">
    <form action="search.php" method="get">
        <input type="text" name="q" placeholder="Search articles..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<div class="container">
<?php
if (!empty($searchTerm)) {
    if ($results && $results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            echo "<div class='card'>
                    <div style='color:gray;font-size:14px;'>{$row['category']} | " . date('M d, Y', strtotime($row['created_at'])) . "</div>
                    <h3><a href='article.php?id={$row['id']}'>" . htmlspecialchars($row['title']) . "</a></h3>
                    <p>" . htmlspecialchars(substr($row['summary'], 0, 100)) . "...</p>
                    <a href='article.php?id={$row['id']}'>Read More →</a>
                  </div>";
        }
    } else {
        echo "<p style='text-align:center;'>No results found for '<strong>" . htmlspecialchars($searchTerm) . "</strong>'.</p>";
    }
} else {
    echo "<p style='text-align:center;'>Please enter a search term.</p>";
}
?>
</div>

</body>
</html>
