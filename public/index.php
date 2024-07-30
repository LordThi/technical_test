<?php

use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

return function (array $context) {
    $kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
    $request = Request::createFromGlobals();

    // Servir les fichiers statiques React
    $pathInfo = $request->getPathInfo();
    if (preg_match('/\.(?:js|css|map|ico|png|jpg|jpeg|svg|woff|woff2)$/', $pathInfo)) {
        return false;
    }

    return $kernel->handle($request);
};
