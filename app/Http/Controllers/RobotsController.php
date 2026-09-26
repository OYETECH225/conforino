<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;
use Symfony\Component\HttpFoundation\Response;

class RobotsController extends Controller
{
    public function __invoke(GeneralSettings $settings): Response
    {
        return response($settings->robots_txt, 200, ['Content-Type' => 'text/plain']);
    }
}
