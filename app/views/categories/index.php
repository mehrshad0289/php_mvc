<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="">Categories</h5>
                    <a href="<?= URL_ROOT ?>/categories/create" class="btn btn-dark">create</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category) : ?>
                                <tr>
                                    <td><?= $category->title ?></td>
                                    <td>
                                        <a href="<?= URL_ROOT ?>/categories/edit/<?= $category->id ?>" class="btn btn-sm btn-secondary">Edit</a>
                                        <form class="d-inline" action="<?= URL_ROOT ?>/categories/delete/<?= $category->id ?>" method="POST">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>