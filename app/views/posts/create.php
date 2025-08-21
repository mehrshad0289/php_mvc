<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="">Create Post</h5>
                    <a href="<?= URL_ROOT ?>/posts" class="btn btn-dark">back</a>
                </div>

                <div class="card-body">
                    <form action="<?= URL_ROOT ?>/posts/store" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control">
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['form_errors']['title'])) : ?>
                                    <?= $_SESSION['form_errors']['title'] ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select type="text" name="category_id" class="form-select">
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category->id ?>"><?= $category->title ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['form_errors']['category_id'])) : ?>
                                    <?= $_SESSION['form_errors']['category_id'] ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Body</label>
                            <textarea type="text" name="body" class="form-control" rows="3"></textarea>
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['form_errors']['body'])) : ?>
                                    <?= $_SESSION['form_errors']['body'] ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-secondary">Submit</button>
                        <?php if (isset($_SESSION['form_errors'])) : ?>
                            <?php unset($_SESSION['form_errors']) ?>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>