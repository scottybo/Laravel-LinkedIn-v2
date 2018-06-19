<?php

namespace Scottybo\LinkedInV2\Tests;

use Orchestra\Testbench\TestCase;
use Scottybo\LinkedIn\LinkedinServiceProviderV2;
use Scottybo\LinkedIn\Facades\LinkedInV2;

abstract class AbstractTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
      return [LinkedinServiceProviderV2::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LinkedInV2' => LinkedInV2::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('linkedin-v2.api_key', 'yourapikey');
        $app['config']->set('linkedin-v2.api_secret', 'yourapisecret');
    }
}
