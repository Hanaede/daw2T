<?php

use App\Models\Blog;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../vendor/autoload.php';
    require '../bootstrap.php';

    $title = $_POST['title'] ?? '';
    $tags = $_POST['tags'] ?? '';
    $description = $_POST['description'] ?? '';
    $author = $_POST['author'] ?? 'Anonymous';
    $imagePath = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageName = time() . '_' . $_FILES['image']['name'];
        $imagePath = 'img/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $blog = new Blog();
    $blog->title = $title;
    $blog->tags = $tags;
    $blog->blog = $description;
    $blog->author = $author;
    $blog->image = $imagePath;
    $blog->save();

    echo "<p>Blog post added successfully!</p>";
    echo "<a href='index_sb.php'>Go back</a>";
} else {
    echo "<p>Invalid request.</p>";
}
?>
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html"; charset=utf-8" />
      <link href='http://fonts.googleapis.com/css?family=Irish+Grover' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=La+Belle+Aurore' rel='stylesheet' type='text/css'>
      <link href="css/screen.css" type="text/css" rel="stylesheet" />
      <link href="css/sidebar.css" type="text/css" rel="stylesheet" />
      <link href="css/blog.css" type="text/css" rel="stylesheet" />
      <link rel="shortcut icon" href="img/favicon.ico" />
      </head>
    <body>
      <section id="wrapper">
        <header id="header">
          <div class="top">
            <nav>
              <ul class="navigation">
                <li><a href="index_sb.php">Home</a></li>
                <li><a href="about_sb.php">About</a></li>
                <li><a href="contact_sb.php">Contact</a></li>
              </ul>
            </nav>
          </div>
          <hgroup>
            <h2><a href="index_sb.php/">symblog</a></h2>
            <h3><a href="index_sb.php/">creating a blog in Symfony2</a></h3>
           </hgroup>
        </header>
        <section class="main-col">
    

    <section class="main-col">
        <article class="blog">
            <header>
                <h2>Add a New Blog Post</h2>
            </header>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="tags">Tags:</label>
                    <input type="text" id="tags" name="tags" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div>
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <div>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </article>
    </section>
       <div id="footer">
            dwes symblog - created by <a href="#">dwes</a>
       </div>
    </section>
</body>
</html>