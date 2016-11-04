<?php

namespace BrianFaust\Tests\Taggable;

use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass($app)
    {
        return \BrianFaust\Taggable\ServiceProvider::class;
    }
}
