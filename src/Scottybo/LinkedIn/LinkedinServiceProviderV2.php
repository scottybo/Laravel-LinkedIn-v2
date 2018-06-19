<?php
/**
 * Linkedin API for Laravel Framework
 *
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Scottybo\LinkedInV2;

use Http\Adapter\Guzzle6\Client;
use Illuminate\Support\ServiceProvider;
use Http\Adapter\Guzzle6\Client as HttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory as HttpGuzzleMessageFactory;

class LinkedinServiceProviderV2 extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //Publish config file
        if(function_exists('config_path')){
            //If is not a Lumen App...
            $this->publishes([
                __DIR__ . '/config/linkedin-v2.php' => config_path('linkedin-v2.php'),
            ]);

            $this->mergeConfigFrom(
                __DIR__ . '/config/linkedin-v2.php', 'linkedin-v2'
            );
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('LinkedInV2', function(){
            $linkedIn = new LinkedInLaravelV2(config('linkedin-v2.api_key'), config('linkedin-v2.api_secret'));
            $linkedIn->setHttpClient(new Client());
            $linkedIn->setHttpMessageFactory(new HttpGuzzleMessageFactory());

            return $linkedIn;
        });

        $this->app->alias('LinkedInV2', 'linkedin-v2');
    }
}
