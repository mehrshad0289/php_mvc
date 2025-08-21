<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="">Register</h5>
                </div>
                <div class="card-body">
                    <form action="<?= URL_ROOT ?>/users/store" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['form_errors']['email'])) : ?>
                                    <?= $_SESSION['form_errors']['email'] ?>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['form_errors']['password'])) : ?>
                                    <?= $_SESSION['form_errors']['password'] ?>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control">
                            <div class="form-text text-danger">
                                <?php if (isset($_SESSION['form_errors']['confirm_password'])) : ?>
                                    <?= $_SESSION['form_errors']['confirm_password'] ?>
                                <?php endif ?>
                            </div>
                        </div>

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