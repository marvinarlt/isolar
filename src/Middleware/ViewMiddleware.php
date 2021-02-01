<?php

namespace Isolar\Middleware;

use Closure;
use Isolar\Http\Request;
use Isolar\Service\I18nService;
use Isolar\Service\ViewService;

class ViewMiddleware extends AbstractMiddleware implements MiddlewareInterface
{
    /**
     * Handle the request before the controller.
     * 
     * @param Request $request
     * @param Closure $next
     * 
     * @return void|string
     */
    public function handle(Request $request, Closure $next)
    {
        $i18nService = $this->app->getInstance(I18nService::class);
        $viewService = $this->app->getInstance(ViewService::class);

        $translation = $i18nService->getTranslation();
        $viewService->setTranslation($translation);

        $next();
    }
}