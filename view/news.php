<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <title>News</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include "../component/header.php"; ?>
<div class="container">
    <div class="border text-center rounded-3 my-3 p-4">
        <h1>News</h1>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <?php
            $conn = new PDO("mysql:host=localhost; dbname=local.pu911.com", "root", "");
            $reader = $conn->query("SELECT * FROM news");

            foreach ($reader as $row) {
                echo "
                    <div class='card rounded-3 mb-4'>
                        <div class='row'>
                            <div class='col-md-5'>
                                <img class='img-fluid' src='../assets/img/news/{$row['image']}' alt=''>
                            </div>
                            <div class='col-md-7 mt-3 my-md-2'>
                                <div class='badge bg-danger my-2'>Sport</div>
                                <h3>{$row['name']}</h3>
                                <p>{$row['description']}</p>
                                <ul class='nav align-items-center'>
                                    <li class='nav-item'>
                                        <a class='nav-link link-secondary'>
                                            <div class='d-flex align-items-center'>
                                                <img class='rounded-circle' src='/assets/img/user/nicolas-horn-MTZTGvDsHFY-unsplash.jpg' alt='' width='32' height='32'>
                                                <span class='ms-2'>By RazDva</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class='nav-item'>
                                        <span>Jan 22, 2021</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    ";
            }
            ?>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>