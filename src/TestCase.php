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
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use Throwable;

/**
 * Class TestCase
 * @package coffeephp\quality-tools
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-10-09
 */
abstract class TestCase extends PhpUnitTestCase
{
    /**
     * @var bool
     */
    private static bool $isFirstSetup = true;

    /**
     * Check that the given callback throws the given exception type.
     *
     * @param callable $run
     * @param string $exceptionClassName
     * @param string|null $expectedMessage
     * @param mixed $expectedCode
     */
    public static function assertException(
        callable $run,
        string $exceptionClassName = Throwable::class,
        ?string $expectedMessage = null,
        mixed $expectedCode = null
    ): void {
        try {
            $run();
            self::fail('Failed asserting that an exception was thrown.');
        } catch (AssertionFailedError $e) {
            throw $e;
        } catch (Throwable $e) {
            self::assertInstanceOf($exceptionClassName, $e);
            if ($expectedMessage !== null) {
                self::assertSame($expectedMessage, $e->getMessage());
            }
            if ($expectedCode !== null) {
                self::assertSame($expectedCode, $e->getCode());
            }
        }
    }

    /**
     * @var array<string, Generator>
     */
    private array $fakers = [];

    /**
     * Runs before all tests, allows inheriting methods to perform some initial bootstrap.
     *
     * @before
     */
    final public function runBeforeAllTests(): void
    {
        if (self::$isFirstSetup) {
            $this->setUpBeforeAllTests();
            self::$isFirstSetup = false;
        }
    }

    /**
     * Get an instance of a faker object.
     *
     * @param string $locale
     * @return Generator
     */
    final public function getFaker(string $locale = Factory::DEFAULT_LOCALE): Generator
    {
        if (!isset($this->fakers[$locale])) {
            $this->fakers[$locale] = Factory::create($locale);
        }
        return $this->fakers[$locale];
    }

    /**
     * Perform initial bootstrap before any tests are executed.
     */
    protected function setUpBeforeAllTests(): void
    {
        Mockery::globalHelpers();
    }
}
