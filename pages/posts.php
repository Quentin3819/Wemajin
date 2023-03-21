<?php
include "../template-part/header.php";
if (isset($_GET['id'])):
    // Si il y a un parametre id en GET alors on vas afficher un single post
    $postId = $_GET['id'];
    $postJson = file_get_contents("../posts/post-" . $postId . ".json");
    $post = json_decode($postJson, true);?>
    <div>
        <h1><?= $post['title'] ?></h1>
        <p><?= $post['content'] ?></p>
    </div>
<?php else:
    // Sinon on vas afficher tout les post
    $files = '../posts/' . '*' . '.json';
    foreach (glob($files) as $file) :
        $postJson = file_get_contents($file);
        $post = json_decode($postJson, true);
        $postId = $post['id'];
        $title = $post['title'];
        $content = $post['content'];
        if (strlen($content) > 50) {
            $content = substr($content, 0, 300) . '...';
        } ?>
        <a href="../pages/posts.php?id=<?= $postId ?>">
            <div>
                <h1><?= $title ?></h1>
                <p><?= $content ?></p>
            </div>
        </a>
    <?php endforeach; ?>
<?php endif;
include "../template-part/footer.php";
