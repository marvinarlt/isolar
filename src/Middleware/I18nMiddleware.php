<?php

namespace Isolar\Middleware;

use Closure;
use Isolar\Http\Request;
use Isolar\Service\I18nService;

class I18nMiddleware extends AbstractMiddleware implements MiddlewareInterface
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
        $locale = $request->getParameter('locale');

        $i18nService = $this->app->getInstance(I18nService::class);
        $i18nService->setLocale($locale);
        $i18nService->loadTranslation();

        $next();
    }
}