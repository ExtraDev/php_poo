<h1>Administration des articles</h1>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Publié le</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($params['posts'] as $post) : ?>
            <tr>
                <th scope="row"><?= $post->id_post ?></th>
                <td><?= $post->title ?></td>
                <td><?= $post->getCreatedAt() ?></td>
                <td>
                    <a href="/admin/post/edit/<?= $post->id_post ?>" class="btn btn-warning">Modifier</a>
                    <form action="/admin/posts/delete/<?=$post->id_post?>" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>