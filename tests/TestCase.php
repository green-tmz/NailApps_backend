<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public const BASE_PATH = 'http://127.0.0.1:85/api/v1';
}
