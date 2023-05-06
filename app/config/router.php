<?php

use Phalcon\Mvc\Micro\Collection;

//Default Route
$default = new Collection();
$default->setHandler('app\controllers\IndexController', true);

$default->get('/', 'indexAction');
$default->get('/info', 'infoAction');

$default->get('/api', 'getAction');
$default->post('/api', 'postAction');
$default->put('/api', 'putAction');
$default->delete('/api', 'deleteAction');

$application->mount($default);

$application->after(function() use($application) {
    if($application->request->getURI() == '/info')
    {
        $output_content = $application->getReturnedValue();
    }
    else
    {
        $application->response->setContentType('application/json', 'UTF-8');
        $output_content = json_encode($application->getReturnedValue(), JSON_UNESCAPED_SLASHES);
    }

    $application->response->setContent($output_content);
    $application->response->send();
});

$application->notFound(function () use ($application) {
    $application->response->setStatusCode(404, 'Not Found');
    $application->response->sendHeaders();

    $message = 'Action Not Found';
    $application->response->setContent($message);
    $application->response->send();
});

$application->error(function(\Exception $ex) use($application) {
    $content = [
        'status' => 'ERROR',
        'code' => $ex->getCode(),
        'description' => $ex->getMessage()
    ];

    $application->response->setContentType('application/json', 'UTF-8');
    $output_content = json_encode($content, JSON_UNESCAPED_SLASHES);
    $application->response->setContent($output_content);
    $application->response->setStatusCode(400);
    $application->response->send();
    exit;
});