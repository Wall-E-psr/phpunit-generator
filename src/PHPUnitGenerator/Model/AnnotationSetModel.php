<?php

/**
 * This file is part of PHPUnit Generator.
 *
 * (c) Paul Thébaud <paul.thebaud29@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPUnitGenerator\Model;

use PHPUnitGenerator\Model\ModelInterface\AnnotationModelInterface;
use PHPUnitGenerator\Model\ModelInterface\MethodModelInterface;

/**
 * Class AnnotationSetModel
 *
 *      An implementation of AnnotationModelInterface to support following
 *      annotations:
 *      "@PHPUnitGen\Set()"
 *
 * @package PHPUnitGenerator\Model
 */
class AnnotationSetModel extends AbstractAnnotationModel
{
    /**
     * {@inheritdoc}
     */
    public function __construct(MethodModelInterface $methodModel)
    {
        parent::__construct($methodModel);

        $this->setType(AnnotationModelInterface::TYPE_SET);
    }

    /**
     * {@inheritdoc}
     */
    public function getCall(): string
    {
        return parent::getCall() . ($this->getParentMethod()->isPublic() ? '' : ', ');
    }
}
