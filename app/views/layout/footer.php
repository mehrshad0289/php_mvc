<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

<script src="<?= URL_ROOT ?>/public/assets/js/app.js"></script>

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<script>
    alertify.set('notifier', 'position', 'top-right');

    <?php if (isset($_SESSION['success'])) : ?>
        alertify.success("<?= $_SESSION['success'] ?>");
        <?php unset($_SESSION['success']) ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])) : ?>
        alertify.error("<?= $_SESSION['error'] ?>");
        <?php unset($_SESSION['error']) ?>
    <?php endif; ?>
</script>


</body>

</html>