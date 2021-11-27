<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new PDO("mysql:host=localhost;dbname=local.pu911.com", "root", "");
    $sql = "INSERT INTO `news` (`name`, `image`, `date`, `category`, `excerpt`, `description`) VALUES (?, ?, ?, ?, ?, ?);";

    $name = $_POST['title'];
    $fileName = uniqid() . '.jpg';
    $description = $_POST['description'];
    $date = $_POST['date'];
    $excerpt = $_POST['excerpt'];
    $category = $_POST['category'];

    $filePath = $_SERVER["DOCUMENT_ROOT"] . '/assets/img/news/' . $fileName;
    move_uploaded_file($_FILES['imageFile']['tmp_name'], $filePath);

    $conn->prepare($sql)->execute([$name, $fileName, $date, $category, $excerpt, $description]);

    header("Location: /view/admin/news/indexNews.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <title>Create News</title>
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "../../../component/sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-md-3" style="height: 100vh">
            <h2>Create News</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="row mt-3">
                    <div class="col-7">
                        <div class="card mb-3">
                            <div class="card-header">
                                General
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           placeholder="Enter title"/>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="category" class="form-label">Category</label>
                                            <select id="category" name="category" class="form-select">
                                                <option value="" disabled selected>Select...</option>
                                                <option value="Sport">Sport</option>
                                                <option value="Travel">Travel</option>
                                                <option value="Tech">Tech</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="date" class="form-label">Data</label>
                                            <input type="date" name="date" id="date" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="excerpt" class="form-label">Excerpt</label>
                                    <textarea type="text" name="excerpt" id="excerpt" class="form-control"
                                              placeholder="Enter excerpt"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" name="description" id="description" class="form-control"
                                              placeholder="Enter text"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="card mb-3">
                            <div class="card-header">
                                Image
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <label for="imageFile" class="form-label">
                                        <img src="https://www.pngall.com/wp-content/uploads/2/Upload-Transparent.png"
                                             id="imgPreview" class="img-fluid"/>
                                    </label>
                                    <button type="button" id="imageBtn" class="browse btn btn-primary px-4">Browse
                                    </button>
                                    <input type="text" name="imageName" id="imageName"
                                           class="form-control form-control-lg" placeholder="Upload Image"/>
                                    <input type="file" name="imageFile" id="imageFile" class="d-none"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <a type="submit" class="btn btn-secondary" href="/view/admin/news/indexNews.php">Back</a>
                        <button type="submit" class="btn btn-primary float-right">Create</button>
                    </div>
            </form>
    </div>
    </main>
</div>
</div>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('load', function () {
        const imageBtn = document.getElementById('imageBtn')
        imageBtn.addEventListener("click", function (e) {
            const imageFile = document.getElementById('imageFile');
            imageFile.click();

            imageFile.addEventListener("change", function (e) {
                const imageName = e.currentTarget.files[0].name;
                document.getElementById('imageName').value = imageName;

                const imageUpload = e.currentTarget.files[0];
                document.getElementById('imgPreview').src = URL.createObjectURL(imageUpload);
            })
        })
    })
</script>
</body>
</html>