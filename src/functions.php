<?php

if(class_exists(\Scrawler\App)){
    \Scrawler\App::engine()->registerHandler('exception', function($e){
            $whoops = new \Whoops\Run;
            $whoops->allowQuit(false);
            $whoops->writeToOutput(false);
            if(\Scrawler\App::engine()->config()->has('api') && \Scrawler\App::engine()->config()->get('api')){
                $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
            }else{
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            }
            return $whoops->handleException($e);
    });
}else{
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}


