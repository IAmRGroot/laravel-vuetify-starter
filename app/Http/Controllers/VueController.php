<?php

namespace App\Http\Controllers;

use Exception;

class VueController extends Controller
{
    /**
     * @throws Exception
     */
    public function page(): string
    {
        $content = file_get_contents(public_path('vue/index.html'));

        if (! $content) {
            throw new Exception('View couldn\'t be opened');
        }

        return $content;
    }
}
