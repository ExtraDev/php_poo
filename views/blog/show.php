<h1><?= $params['post']->title ?></h1>
<div>
    <?php foreach( $params['post']->getTags() as $tag ): ?>
        <span class="badge bg-secondary"><a class="text-white" href="/tags/<?= $tag->id_tag ?>"><?= $tag->name ?></a></span>
    <?php endforeach ?>
</div>
<p>
    <?= $params['post']->content ?>
</p>
<a href="/posts" class="btn btn-secondary">Retourner en arrière</a>