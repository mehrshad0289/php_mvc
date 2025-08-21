<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 col-md-4">
            <form action="<?= URL_ROOT ?>/users/search" method="GET" class="input-group me-3">
                <input type="text" name="query" value="<?= $_GET['query'] ?? '' ?>" class="form-control" placeholder="keyword ...">
                <button type="submit" class="input-group-text btn btn-dark">search</button>
            </form>
        </div>
        <div class="col-12 col-md-2">
            <a href="<?= URL_ROOT ?>/users/list" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <?php if (empty($users)) : ?>
        <div class="alert alert-danger">
            No results were found for your search <strong>[<?= isset($_GET['query']) ? $_GET['query'] : "......." ?>]</strong>
        </div>
    <?php else : ?>
        <div class="row g-3 justify-content-center mb-4">

            <?php foreach ($users as $user) : ?>
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $user->email ?></h5>

                            <?php if (isset($user->image)) : ?>
                                <img src="<?= $user->image ?>" alt="user image" class="img-fluid" style="width: 100px; height: 100px;">
                            <?php endif; ?>



                        </div>
                    </div>
                </div>
            <?php endforeach ?>

        </div>
    <?php endif ?>
</div>
