<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>

<?php
include('../Class/Api.php');

if(isset($_POST['submit'])){
    $api = new Api();
    $title = $api->generateTitle($_POST['title']);
    $postId = $api->generatePost($title);
    header("Location: posts.php?id=" . $postId);
}else{
    include('../template-part/form.php');
}
?>

</body>
</html>