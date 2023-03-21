<?php if (isset($_GET['id'])):
    include('../Class/Api.php');
    if (isset($_POST['submit'])) {
        $json = array("id" => $_GET['id'], "title" => $_POST['title'], "content" => $_POST['contenu']);
        $jsonContent = json_encode($json);
        $updatePost = file_put_contents("../posts/post-" . $_GET['id'] . ".json", $jsonContent, true);
        if ($updatePost) {
            header("Location: posts.php?id=" . $_GET['id']);
        }
    } else {
        include('../template-part/update-form.php');
    }
endif; ?>