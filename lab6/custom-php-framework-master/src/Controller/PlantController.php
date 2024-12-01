<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Plant;
use App\Service\Router;
use App\Service\Templating;

class PlantController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $plants = Plant::findAll();
        $html = $templating->render('plant/index.html.php', [
            'plants' => $plants,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestPlant, Templating $templating, Router $router): ?string
    {
        if ($requestPlant) {
            $plant = Plant::fromArray($requestPlant);
            // @todo missing validation
            $plant->save();

            $path = $router->generatePath('plant-index');
            $router->redirect($path);
            return null;
        } else {
            $plant = new Plant();
        }

        $html = $templating->render('plant/create.html.php', [
            'plant' => $plant,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $plantId, ?array $requestPlant, Templating $templating, Router $router): ?string
    {
        $plant = Plant::find($plantId);
        if (! $plant) {
            throw new NotFoundException("Missing plant with id $plantId");
        }

        if ($requestPlant) {
            $plant->fill($requestPlant);
            // @todo missing validation
            $plant->save();

            $path = $router->generatePath('plant-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('plant/edit.html.php', [
            'plant' => $plant,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $plantId, Templating $templating, Router $router): ?string
    {
        $plant = Plant::find($plantId);
        if (! $plant) {
            throw new NotFoundException("Missing plant with id $plantId");
        }

        $html = $templating->render('plant/show.html.php', [
            'plant' => $plant,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $plantId, Router $router): ?string
    {
        $plant = Plant::find($plantId);
        if (! $plant) {
            throw new NotFoundException("Missing plant with id $plantId");
        }

        $plant->delete();
        $path = $router->generatePath('plant-index');
        $router->redirect($path);
        return null;
    }
}
