<?php

if(class_exists(\Scrawler\App::class) && function_exists('app')){
    app()->registerHandler('exception', function($e){
            $whoops = new \Whoops\Run;
            $whoops->allowQuit(false);
            $whoops->writeToOutput(false);
            if(\Scrawler\App::engine()->config()->has('api') && \Scrawler\App::engine()->config()->get('api')){
                $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
            }else{
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            }
            $output = $whoops->handleException($e);
            app()->response()->setStatusCode(500);
            app()->response()->setContent($output);
            app()->response()->send();
            
    });
}else{
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}


