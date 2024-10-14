<?php
/*
 * This file is part of the Scrawler package.
 *
 * (c) Pranjal Pandey <its.pranjalpandey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Scrawler\App;

if (class_exists(App::class) && function_exists('app')) {
    App::engine()->handler('exception', function ($e) {
        $whoops = new Whoops\Run();
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        if (App::engine()->config()->get('api', false)) {
            $whoops->pushHandler(new Whoops\Handler\JsonResponseHandler());
        } else {
            $pretty = new Whoops\Handler\PrettyPageHandler();
            $pretty->addDataTable('Scrawler', [
                'Version' => App::engine()->getVersion(),
            ]);
            $whoops->pushHandler($pretty);
        }
        if (App::engine()->config()->get('debug', false)) {
            $output = App::engine()->call(App::engine()->getHandler('500'));
        } else {
            $output = $whoops->handleException($e);
        }
        App::engine()->response()->setStatusCode(500);
        App::engine()->response()->setContent($output);
        App::engine()->response()->send();
    });
} else {
    $whoops = new Whoops\Run();
    $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}
