
<?php
require_once '../../bootstrap.php';
use App\Models\Blog;

$blogs = Blog::all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/blog.css">
    <title>Lista de Blogs</title>
</head>
<body>
    <h1>Lista de Blogs</h1>
    <ul>
        <?php foreach ($blogs as $blog): ?>
            <li>
                <h2><?php echo htmlspecialchars($blog->title); ?></h2>
                <p><?php echo htmlspecialchars($blog->author); ?></p>
                <p><?php echo htmlspecialchars($blog->blog); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>