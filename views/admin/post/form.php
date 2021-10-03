<h1><?= $params['post']->name ?? 'Créer un nouvel article'?></h1>

<form action="<?= isset($params['post']) ? "/admin/post/edit/{$params['post']->id_post}" : "/admin/post/create"?>" method="POST">
    <div class="form-group mb-3">
        <label for="title">Titre de l'article</label>
        <input type="text" class="form-control" name="title" id="title" value="<?= $params['post']->title ?? "" ?>">
    </div>
    <div class="form-group mb-3">
        <label for="content">Contenu de l'article</label>
        <textarea name="content" id="content" class="form-control" cols="30" rows="8"><?= $params['post']->content ?? "" ?></textarea>
    </div>
    <div class="form-group">
        <label for="tags">Tag de l'article</label>
        <select multiple class="form-select mb-3" id="tags" name="tags[]">
            
            <?php foreach($params['tags'] as $tag) :?>
                <option value="<?= $tag->id_tag ?>"
                    <?php if(isset($params['post'])): ?>
                        <?php foreach($params['post']->getTags() as $post_tag) {
                            echo ($tag->id_tag === $post_tag->id_tag)? "selected":" ";
                        } ?>
                    <?php endif ?>
                ><?= $tag->name ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary"><?= isset($params['post']) ? 'Enregistrer les modifications' : 'Créer mon article' ?></button>
</form>
