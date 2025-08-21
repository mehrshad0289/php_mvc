<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class=""> Profile </h5>
                    <img src="<?= $user->image ?>" alt="user image" class="img-fluid" style="width: 100px; height: 100px;">

                </div>
                <div class="card-body">
                    <form action="<?= URL_ROOT ?>/users/update-profile-and-image" method="POST"  enctype="multipart/form-data" >
                        <!-- user image -->
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*"">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $user->email ?>">
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['form_errors']['email'])) : ?>
                                    <?= $_SESSION['form_errors']['email'] ?>
                                <?php endif ?>
                            </div>
                        </div>

                        <!-- <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" value="<?= $user->password ?>">
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['form_errors']['password'])) : ?>
                                    <?= $_SESSION['form_errors']['password'] ?>
                                <?php endif ?>
                            </div>
                        </div> -->

                        <button type="submit" class="btn btn-secondary">Submit</button>
                        <?php if (isset($_SESSION['form_errors'])) : ?>
                            <?php unset($_SESSION['form_errors']) ?>
                        <?php endif ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>