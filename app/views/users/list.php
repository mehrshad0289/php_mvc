<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 col-md-4">
            <form action="<?= URL_ROOT ?>/users/search" method="GET" class="input-group me-3">
                <input type="text" name="query" class="form-control" placeholder="keyword ...">
                <button type="submit" class="input-group-text btn btn-dark">search</button>
            </form>
        </div>
        <form action="<?= URL_ROOT ?>/users/list" method="GET" class="input-group me-3">
            <div class="col-12 col-md-4">
                <select name="sort_email" class="form-control" id="sort_email">
                    <option value="" disabled hidden selected>Sort by email</option>
                    <option value="asc" <?= (isset($_GET['sort_email']) && $_GET['sort_email'] === 'asc') ? 'selected' : '' ?>>A-Z</option>
                    <option value="desc" <?= (isset($_GET['sort_email']) && $_GET['sort_email'] === 'desc') ? 'selected' : '' ?>>Z-A</option>
                </select>
            </div>
            <button type="submit" class="input-group-text btn btn-dark">filter</button>
        </form>
        <form action="<?= URL_ROOT ?>/users/list" method="GET" class="input-group me-3">
            <div class="col-12 col-md-4">
                <select name="sort_date" class="form-control" id="sort_date">
                    <option value="" disabled hidden selected>Sort by date</option>
                    <option value="asc" <?= (isset($_GET['sort_date']) && $_GET['sort_date'] === 'asc') ? 'selected' : '' ?>>Oldest</option>
                    <option value="desc" <?= (isset($_GET['sort_date']) && $_GET['sort_date'] === 'desc') ? 'selected' : '' ?>>Newest</option>
                </select>
            </div>
            <button type="submit" class="input-group-text btn btn-dark">filter</button>
        </form>

        <div class="row g-3 justify-content-center mb-4">

            <?php foreach ($users as $user) : ?>
                <div class="col-12 col-md-4" >
                    <div class="card" style="width: 300px; height: 250px; margin: 10px;">
                        <div class="card-body">
                            <!-- تاریخ عضویت  -->
                            <div>

                                <div class="card-subtitle mb-2 badge text-bg-secondary"><?= $user->created_at ?></div>
                            </div>
                            <h5 class="card-title"><?= $user->email ?></h5>

                            <?php if (isset($user->image)) : ?>
                                <img src="<?= $user->image ?>" alt="user image" class="img-fluid" style="width: 100px; height: 100px;">
                            <?php endif; ?>




                        </div>
                    </div>
                </div>
            <?php endforeach ?>

        </div>


        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <nav>
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                <a href="<?= URL_ROOT ?>/users/list?page=<?= $i ?>&sort_email=<?= $_GET['sort_email'] ?? '' ?>&sort_date=<?= $_GET['sort_date'] ?? '' ?>" class="page-link"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>