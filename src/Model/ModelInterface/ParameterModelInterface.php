<?php

/**
 * This file is part of PhpUnitGen.
 *
 * (c) 2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace PhpUnitGen\Model\ModelInterface;

use PhpUnitGen\Model\PropertyInterface\TypeInterface;
use PhpUnitGen\Model\PropertyInterface\VariableLikeInterface;

/**
 * Interface ParameterModelInterface.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
interface ParameterModelInterface extends VariableLikeInterface, TypeInterface
{
    /**
     * @param bool $isVariadic The new variadic value to set.
     */
    public function setIsVariadic(bool $isVariadic): void;

    /**
     * @return bool True if it is variadic.
     */
    public function isVariadic(): bool;
}
