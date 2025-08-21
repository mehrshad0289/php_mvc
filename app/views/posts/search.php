<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 col-md-4">
            <form action="<?= URL_ROOT ?>/posts/search" method="GET" class="input-group me-3">
                <input type="text" name="query" class="form-control" placeholder="keyword ...">
                <button type="submit" class="input-group-text btn btn-dark">search</button>
            </form>
        </div>
        <div class="col-12 col-md-2">
            <a href="<?= URL_ROOT ?>/posts" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <?php if (empty($posts)) : ?>
        <div class="alert alert-danger">
            No results were found for your search <strong>[<?= isset($_GET['query']) ? $_GET['query'] : "......." ?>]</strong>
        </div>
    <?php else : ?>
        <div class="row g-3 justify-content-center mb-4">

            <?php foreach ($posts as $post) : ?>
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->title ?></h5>

                            <div class="card-subtitle mb-2 badge text-bg-secondary"><?= $post->category_title ?></div>

                            <p class="card-text"><?= $post->body ?></p>

                            <div class="d-flex align-items-center">
                                <a href="<?= URL_ROOT ?>/posts/edit/<?= $post->id ?>" class="card-link">Edit post</a>
                                <form class="mb-0" action="<?= URL_ROOT ?>/posts/delete/<?= $post->id ?>" method="POST">
                                    <button type="submit" class="btn btn-link text-danger">Delete Post</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach ?>

        </div>
    <?php endif ?>

</div>