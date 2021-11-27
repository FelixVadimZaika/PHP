<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <title>Contacts</title>
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/a6ca4f91fd.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "../../../component/sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-md-3" style="height: 100vh">
            <h2>News</h2>
            <a class="btn btn-primary" href="createNews.php">Add news</a>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th style="width: 5%;">Id</th>
                        <th style="width: 20%;">Title</th>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 30%;">Excerpt</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = new PDO("mysql:host=localhost; dbname=local.pu911.com", "root", "");
                        $reader = $conn->query("SELECT * FROM news");

                        foreach ($reader as $row) {
                            echo "
                                <tr>
                                    <td class='align-middle'>{$row['id']}</td>
                                    <td class='align-middle'>{$row['name']}</td>
                                    <td class='align-middle'>{$row['date']}</td>
                                    <td class='align-middle'>{$row['category']}</td>
                                    <td class='align-middle'>{$row['excerpt']}</td>
                                    <td class='align-middle'>
                                        <nav class='nav'>
                                            <li class='nav-item'>
                                                <a class='nav-link p-1' href='#'>
                                                    <i class='fas fa-eye'></i>
                                                </a>
                                            </li>
                                            <li class='nav-item'>
                                                <a class='nav-link p-1' href='/view/Admin/news/updateNews.php?id=" . $row["id"] . "&image=" . $row["image"] . "'>
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                            </li>
                                            <li class='nav-item'>
                                                <a class='nav-link p-1 btn-delete-news' data-id='{$row['id']}' data-image='{$row['image']}'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </a>
                                            </li>
                                        </nav>
                                    </td>
                                </tr>
                            ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include "../../../component/modalDeleteNews.php"; ?>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
<script src="../../../assets/js/axios.min.js"></script>
<script>
    const myModal = new bootstrap.Modal(document.getElementById("myModal"), {});

    window.addEventListener('load', function () {
        const list = document.querySelectorAll(".btn-delete-news");
        let removeId = 0;
        let removeImage = "";

        for(let i = 0; i < list.length; i++)
        {
            list[i].addEventListener("click", function (e) {
                e.preventDefault();
                removeId = e.currentTarget.dataset.id;
                removeImage = e.currentTarget.dataset.image;
                myModal.show();
            })
        }

        document.querySelector("#btnDeleteNews").addEventListener("click", function() {
            const formData = new FormData();
            formData.append("id", removeId);
            formData.append("image", removeImage);

            axios.post("/view/admin/news/deleteNews.php", formData)
                .then(resp => {
                    location.reload();
                });
        });
    })
</script>
</body>
</html>


