<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new PDO("mysql:host=localhost;dbname=local.pu911.com", "root", "");

    if ($_GET["image"] == $_POST['imageName']) {
        $sql = "UPDATE news SET name = ?, date = ?, image = '" . $_GET["image"] . "', category = ?, excerpt = ?, description = ? WHERE id = '" . $_GET["id"] . "'";
        $name = $_POST['title'];
        $date = $_POST['date'];
        $category = $_POST['category'];
        $excerpt = $_POST['excerpt'];
        $description = $_POST['description'];

        $conn->prepare($sql)->execute([$name, $date, $category, $excerpt, $description]);
    } else {
        $sql = "UPDATE news SET name = ?, image = ?, date = ?, category = ?, excerpt = ?, description = ? WHERE id = '" . $_GET["id"] . "'";
        $name = $_POST['title'];
        $fileName = uniqid() . '.jpg';
        $date = $_POST['date'];
        $category = $_POST['category'];
        $excerpt = $_POST['excerpt'];
        $description = $_POST['description'];

        $filePathDelete = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/news/' . $_GET["image"];
        unlink($filePathDelete);

        $filePathUpdate = $_SERVER["DOCUMENT_ROOT"] . '/assets/img/news/' . $fileName;
        move_uploaded_file($_FILES['imageFile']['tmp_name'], $filePathUpdate);

        $conn->prepare($sql)->execute([$name, $fileName, $date, $category, $excerpt, $description]);
    }

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
            <h2>Update News</h2>
            <form method="post" enctype="multipart/form-data">
                <?php
                $conn = new PDO("mysql:host=localhost; dbname=local.pu911.com", "root", "");
                $reader = $conn->query("SELECT * FROM news WHERE id = '" . $_GET["id"] . "'");

                if ($reader->rowCount() > 0) {
                    foreach ($reader as $row) {
                        echo "
                        <div class='row mt-3'>
                            <div class='col-7'>
                                <div class='card mb-3'>
                                    <div class='card-header'>
                                        General
                                    </div>
                                    <div class='card-body'>
                                         <div class='form-group mb-3'>
                                              <label for='title' class='form-label'>Title</label>
                                              <input type='text' name='title' id='title' class='form-control' placeholder='Enter title' value='{$row["name"]}'/>
                                         </div>
                                        <div class='row'>
                                            <div class='col-6'>
                                                <div class='form-group mb-3'>
                                                    <label for='category' class='form-label'>Category</label>
                                                    <select id='category' name='category' class='form-select'>
                                                        <option value=''>Select...</option>";
                                                  echo "<option value='Sport'";  if ($row["category"] == "Sport") { echo "selected"; } echo "> Sport</option>";
                                                  echo "<option value='Travel'"; if ($row["category"] == "Travel") { echo "selected"; } echo ">Travel</option>";
                                                  echo "<option value='Tech'"; if ($row["category"] == "Tech") { echo "selected"; } echo ">Tech</option>";
                                              echo "</select>
                                                </div>
                                            </div>
                                            <div class='col-6'>
                                                <div class='form-group mb-3'>
                                                    <label for='date' class='form-label'>Data</label>
                                                    <input type='date' name='date' id='date' class='form-control' value='{$row["date"]}'/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='form-group mb-3'>
                                            <label for='excerpt' class='form-label'>Excerpt</label>
                                            <textarea type='text' name='excerpt' id='excerpt' class='form-control' placeholder='Enter excerpt'>{$row["excerpt"]}</textarea>
                                        </div>
                                        <div class='form-group'>
                                            <label for='description' class='form-label'>Description</label>
                                            <textarea type='text' name='description' id='description' class='form-control' placeholder='Enter text'>{$row["description"]}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-5'>
                                <div class='card mb-3'>
                                    <div class='card-header'>
                                        Image
                                    </div>
                                    <div class='card-body'>
                                        <div class='input-group'>
                                            <label for='imageFile' class='form-label'>
                                                <img src='/assets/img/news/{$row['image']}' class='img-fluid' id='imgPreview' all='img' />
                                            </label>
                                            <button type='button' id='imageBtn' class='browse btn btn-primary px-4'>Browse</button>
                                            <input type='text' name='imageName' id='imageName' class='form-control form-control-lg' value='{$row["image"]}'/>
                                            <input type='file' name='imageFile' id='imageFile' class='d-none'/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-12'>
                                <a type='submit' class='btn btn-secondary' href='/view/admin/news/indexNews.php'>Back</a>
                                <button type='submit' class='btn btn-primary float-right'>Update</button>
                            </div>
                        </div>
                        ";
                    }
                }
                ?>
            </form>
        </main>
    </div>
</div>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('load', function () {
        const imageBtn = document.getElementById('imageBtn')
        imageBtn.addEventListener("click", function () {
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