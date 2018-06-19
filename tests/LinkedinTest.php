<?php

/**
 * Linkedin API for Laravel Framework
 *
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Scottybo\LinkedInV2\Tests;
use Scottybo\LinkedInV2\Facades\LinkedInV2;

class LinkedinTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function test_bindings()
    {
        $bindings = [$this->app['linkedin'], $this->app['LinkedIn']];

        foreach($bindings as $binding) {
          $this->assertInstanceOf(
              \Scottybo\LinkedIn\LinkedIn::class,
              $binding
          );
        }
    }

    /**
     * @test
     */
    public function test_facade()
    {
        $this->assertEquals(
            LinkedInV2::isAuthenticated(),
            false
        );
    }
}
