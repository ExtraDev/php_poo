<h1>Modification du post</h1>


<form action="/admin/post/edit/<?= $params['post']->id_post ?>" method="POST">
    <div class="form-group mb-3">
        <label for="title">Titre de l'article</label>
        <input type="text" class="form-control" name="title" id="title" value="<?= $params['post']->title ?>">
    </div>
    <div class="form-group mb-3">
        <label for="content">Contenu de l'article</label>
        <textarea name="content" id="content" class="form-control" cols="30" rows="8"><?= $params['post']->content ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Sauvergarder</button>
</form>