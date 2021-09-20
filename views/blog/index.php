<h1>Les derniers articles</h1>

<?php foreach($params['posts'] as $post): ?>

    <div class="card mb-3">
        <div class="card-body">
            <h2><?= $post->title ?></h2>
            <div>
                <?php foreach( $post->getTags() as $tag ): ?>
                    <span class="badge bg-success"><a class="text-white" href="/tags/<?= $tag->id_tag ?>"><?= $tag->name ?></a></span>
                <?php endforeach ?>
            </div>
            <small class="">Publié le<?= $post->getCreatedAt() ?></small>
            <p><?= $post->getExcerpt()?></p>
            <?= $post->getButton() ?>
        </div>
    </div>

<?php endforeach ?>