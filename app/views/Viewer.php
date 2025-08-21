<?php
namespace app\views;

class Viewer
{
    public function render($template, $data = [])
    {
        extract($data, EXTR_SKIP);

        require BASE_DIR . "/app/views/layout/header.php";
        require BASE_DIR . "/app/views/$template";
        require BASE_DIR . "/app/views/layout/footer.php";
    }
}
