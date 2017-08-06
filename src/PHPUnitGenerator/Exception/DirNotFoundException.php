<?php

/**
 * This file is part of PHPUnit Generator.
 *
 * (c) Paul Thébaud <paul.thebaud29@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPUnitGenerator\Exception;

use PHPUnitGenerator\Exception\ExceptionInterface\ExceptionInterface;

/**
 * Class DirNotFoundException
 *
 *      If the given file does not exists
 *
 * @package PHPUnitGenerator\Exception
 */
class DirNotFoundException extends \InvalidArgumentException implements ExceptionInterface
{
    /**
     * @var string TEXT The exception description text
     */
    const TEXT = 'The directory "%s" does not exists.';
}