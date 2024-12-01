<?php

/** @var \App\Model\Plant[] $plants */
/** @var \App\Service\Router $router */

$title = 'Plant List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Plants List</h1>

    <a href="<?= $router->generatePath('plant-create') ?>">Create new</a>

    <ul class="index-list">
        <?php foreach ($plants as $plant): ?>
            <li><h3><?= $plant->getType() ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('plant-show', ['id' => $plant->getId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('plant-edit', ['id' => $plant->getId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
