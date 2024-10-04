<?php

if(class_exists(\Scrawler\App::class) && function_exists('app')){
    \Scrawler\App::engine()->handler('exception', function($e){
            $whoops = new \Whoops\Run;
            $whoops->allowQuit(false);
            $whoops->writeToOutput(false);
            if(\Scrawler\App::engine()->config()->get('api',false)){
                $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
            }else{
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            }
            if(\Scrawler\App::engine()->config()->get('debug',false)){
              
                $output = \Scrawler\App::engine()->call(\Scrawler\App::engine()->getHandler('500'));
            }else{
                $output = $whoops->handleException($e);
            }
            \Scrawler\App::engine()->response()->setStatusCode(500);
            \Scrawler\App::engine()->response()->setContent($output);
            \Scrawler\App::engine()->response()->send();
            
    });
}else{
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}


