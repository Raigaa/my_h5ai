<?php
require_once 'H5AI.php';

$rootDirectory = "/home";

$h5ai = new H5AI($rootDirectory);

if (isset($_GET['path'])) {
    $newPath = $_GET['path'];
    if (is_dir($newPath)) {
        $h5ai = new H5AI($newPath);
    }
}

$parentPath = dirname($h5ai->getPath());

if (isset($_GET['action']) && $_GET['action'] === 'getContent' && isset($_GET['path'])) {
    $filePath = $_GET['path'];
    $h5ai = new H5AI('/');
    echo $h5ai->getContent($filePath);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style/style.css">
    <script src="./public/js/script.js"></script>
    <title>Explorer</title>
</head>

<body>
    <h1>Files Explorer</h1>

    <div class="top">

        <?php
        echo $h5ai->getPath();
        ?>
        <br><br>

        <input type="text" id="searchInput" placeholder="Rechercher...">

        <?php
        if ($parentPath !== '/') {
            echo '<a href="?path=' . $parentPath . '">Retour</a>';
        }
        ?>
        <br><br>
    </div>
    <?php
    $h5ai->render();
    ?>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <p></p>
        </div>
    </div>

</body>

</html>