<?php
/**
 * Linkedin API for Laravel Framework
 *
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @copyright Copyright (c) 2015, Mauri de Souza Nunes <github.com/mauri870>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Scottybo\LinkedInV2\Facades;

use Illuminate\Support\Facades\Facade;

class LinkedInV2 extends Facade {

    protected static function getFacadeAccessor() {
        return 'linkedin-v2';
    }
}
