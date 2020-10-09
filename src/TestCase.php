<?php

/**
 * TestCase.php
 *
 * Copyright 2020 Danny Damsky
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package coffeephp\quality-tools
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-10-09
 */

declare(strict_types=1);

namespace CoffeePhp\QualityTools;

use Faker\Factory;
use Faker\Generator;
use Mockery;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

/**
 * Class TestCase
 * @package coffeephp\quality-tools
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-10-09
 */
abstract class TestCase extends PhpUnitTestCase
{
    protected Generator $faker;

    /**
     * TestCase constructor.
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        Mockery::globalHelpers();
        $this->faker = Factory::create();
    }
}
