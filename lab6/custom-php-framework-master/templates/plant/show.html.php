<?php

/** @var \App\Model\Plant $plant */
/** @var \App\Service\Router $router */

$title = "{$plant->getType()} ({$plant->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $plant->getType() ?></h1>
    <article>
        <?= $plant->getContent();?>
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('plant-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('plant-edit', ['id'=> $plant->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
