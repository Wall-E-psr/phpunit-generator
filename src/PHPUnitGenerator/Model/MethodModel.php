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

use PHPUnitGenerator\Exception\InvalidTypeException;
use PHPUnitGenerator\Generator\FixedValueGenerator;
use PHPUnitGenerator\Model\ModelInterface\AnnotationModelInterface;
use PHPUnitGenerator\Model\ModelInterface\ArgumentModelInterface;
use PHPUnitGenerator\Model\ModelInterface\ClassModelInterface;
use PHPUnitGenerator\Model\ModelInterface\MethodModelInterface;
use PHPUnitGenerator\Model\ModelInterface\ModifierInterface;
use PHPUnitGenerator\Model\ModelInterface\TypeInterface;

/**
 * Class ClassModel
 *
 *      An implementation of MethodModelInterface
 *
 * @package PHPUnitGenerator\Model
 */
class MethodModel implements MethodModelInterface
{
    /**
     * @var string $name The method name
     */
    private $name;

    /**
     * @var string $visibility The method visibility
     */
    private $visibility = self::VISIBILITY_PUBLIC;

    /**
     * @var string[] $modifiers The method modifier
     */
    private $modifiers = [];

    /**
     * @var ArgumentModelInterface[] $arguments The method arguments
     */
    private $arguments = [];

    /**
     * @var string $returnType The method return type
     */
    private $returnType = TypeInterface::TYPE_MIXED;

    /**
     * @var bool $returnNullable Tells if the method return value can be null
     */
    private $returnNullable = false;

    /**
     * @var string $documentation The method documentation
     */
    private $documentation = null;

    /**
     * @var AnnotationModelInterface[] $annotations The method annotations
     */
    private $annotations = [];

    /**
     * @var ClassModelInterface $class The declaring class
     */
    private $class;

    /**
     * MethodModel constructor.
     *
     * @param ClassModelInterface $classModel
     * @param string              $name
     */
    public function __construct(ClassModelInterface $classModel, string $name)
    {
        $this->class = $classModel;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * {@inheritdoc}
     */
    public function setVisibility(string $visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiers(): array
    {
        return $this->modifiers;
    }

    /**
     * {@inheritdoc}
     */
    public function setModifiers(array $modifiers)
    {
        $this->modifiers = $modifiers;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasModifier(string $modifier): bool
    {
        foreach ($this->getModifiers() as $currentModifier) {
            if ($modifier === $currentModifier) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    /**
     * {@inheritdoc}
     */
    public function setReturnType(string $returnType)
    {
        $this->returnType = $returnType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReturnNullable(): bool
    {
        return $this->returnNullable;
    }

    /**
     * {@inheritdoc}
     */
    public function setReturnNullable(bool $returnNullable)
    {
        $this->returnNullable = $returnNullable;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

    /**
     * {@inheritdoc}
     */
    public function setDocumentation(string $documentation)
    {
        $this->documentation = $documentation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function setAnnotations(array $annotations)
    {
        $this->annotations = $annotations;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParentClass(): ClassModelInterface
    {
        return $this->class;
    }

    /*
     **********************************************************************
     *
     * Methods which use properties
     *
     **********************************************************************
     */

    /**
     * {@inheritdoc}
     */
    public function getTestName(): string
    {
        return 'test' . ucfirst(str_replace('__', '', $this->name));
    }

    /**
     * {@inheritdoc}
     */
    public function isPublic(): bool
    {
        return self::VISIBILITY_PUBLIC === $this->getVisibility();
    }

    /**
     * {@inheritdoc}
     */
    public function isAbstract(): bool
    {
        return $this->hasModifier(ModifierInterface::MODIFIER_ABSTRACT);
    }

    /**
     * {@inheritdoc}
     */
    public function isStatic(): bool
    {
        return $this->hasModifier(ModifierInterface::MODIFIER_STATIC);
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectToUse(): string
    {
        if ($this->isStatic()) {
            return 'null';
        }
        return '$this->instance';
    }

    /**
     * {@inheritdoc}
     */
    public function generateValue(): string
    {
        try {
            return FixedValueGenerator::generateValue($this->getReturnType());
        } catch (InvalidTypeException $exception) {
            return '/** @todo: A callable value */';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generateValues(): string
    {
        $arguments = [];
        foreach ($this->getArguments() as $argument) {
            $arguments[] = $argument->generateValue();
        }
        return implode(', ', $arguments);
    }
}