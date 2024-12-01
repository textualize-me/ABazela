<?php

/** @var \App\Model\Plant $plant */
/** @var \App\Service\Router $router */

$title = "Edit Plant {$plant->getType()} ({$plant->getId()})";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('plant-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="plant-edit">
        <input type="hidden" name="id" value="<?= $plant->getId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('plant-index') ?>">Back to list</a></li>
        <li>
            <form action="<?= $router->generatePath('plant-delete') ?>" method="post">
                <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                <input type="hidden" name="action" value="plant-delete">
                <input type="hidden" name="id" value="<?= $plant->getId() ?>">
            </form>
        </li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
