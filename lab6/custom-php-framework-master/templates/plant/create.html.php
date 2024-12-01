<?php

/** @var \App\Model\Plant $plant */
/** @var \App\Service\Router $router */

$title = 'Create Plant';
$bodyClass = "create";

ob_start(); ?>
    <h1>Create Plant</h1>
    <form action="<?= $router->generatePath('plant-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="plant-create">
    </form>

    <a href="<?= $router->generatePath('plant-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
