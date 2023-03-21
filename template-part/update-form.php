<?php if (isset($_GET['id'])){
    $postId = $_GET['id'];
    $postJson = file_get_contents("../posts/post-" . $postId . ".json");
    $post = json_decode($postJson, true);
}?>

<form method="post">
    <div>
        <label for="title">Modifier le titre</label>
        <input type="texte" name="title" id="title" required value="<?= $post['title'] ?>">
    </div>
    <div>
        <label for="contenu">Modifier le contenu</label>
        <textarea type="text" name="contenu" id="contenu" required><?= $post['content'] ?></textarea>
    </div>
    <div>
        <input type="submit" value="Subscribe!" name="submit">
    </div>
</form>