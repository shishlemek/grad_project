<!DOCTYPE html>
<html>

<head>
    <title>DMSocial</title>
    <link rel="stylesheet" type="text/css" href="post_style.css">
    <link rel="stylesheet" href="post_container.css">
    <script src="post_container.js"></script>
</head>

<body>
   <h1>My Post</h1>
    <nav class="navbar">
        <img src="img/logo.png" class="logo" alt="">
        <ul class="links-container">
            <li class="link-item"><a href="home.html" class="link">home</a></li>
            <li class="link-item"><a href="post_page.php" class="link">View Posts</a></li>
        </ul>
    </nav>
    <main>
        <!-- <form id="upload-form" method="post">
            <input type="file" name="file" id="file-input" multiple>
            <p id="upload-button"></p>
            <button id="delete-files-button">Remove all files</button>
            <button type="submit" name="upload"><a href="upload.php">Upload</a></button>
        </form> -->
        <form method="POST" enctype="multipart/form-data" action="upload.php">
        <input type="text" name="title" placeholder="Enter title of the post"><br>
        <p id="upload-button"></p>
        <input type="file" name="file" multiple onchange="handleFileSelect(event)"><br>
        <div id="preview-container"></div>
        <input type="submit" name="upload" value="Upload">
    </form>
    <button id="delete-files-button">Remove all files</button>
        <div id="selected-files-container">
            <div id="selected-files"></div>
        </div>

        <!-- <div id="gallery" onclick="removeFileFromGallery(event)"></div> -->

    </main>

    <footer>
        <p>My post | All rights reserved.</p>
    </footer>
    <script src="post_script.js"></script>
</body>

</html>