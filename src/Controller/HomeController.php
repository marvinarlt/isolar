<?php

namespace Isolar\Controller;

use Isolar\Http\Request;

class HomeController extends AbstractController
{
    /**
     * Display the view for the home route.
     * 
     * @param Request $request
     * 
     * @return string
     */
    public function viewAction(Request $request): string
    {
        return $this->view('home');
    }
}