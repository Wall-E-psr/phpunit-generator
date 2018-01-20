<?php

namespace PhpUnitGen\Model;

use Doctrine\Common\Collections\ArrayCollection;
use PhpUnitGen\Model\ModelInterface\InterfaceModelInterface;
use PhpUnitGen\Model\PropertyTrait\ClassLikeTrait;
use PhpUnitGen\Model\PropertyTrait\NameTrait;
use PhpUnitGen\Model\PropertyTrait\NodeTrait;

/**
 * Class InterfaceModel.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
class InterfaceModel implements InterfaceModelInterface
{
    use NameTrait;
    use NodeTrait;
    use ClassLikeTrait;

    /**
     * InterfaceModel constructor.
     */
    public function __construct()
    {
        $this->functions = new ArrayCollection();
    }
}
