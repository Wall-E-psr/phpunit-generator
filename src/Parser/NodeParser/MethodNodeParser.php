<?php

namespace PhpUnitGen\Parser\NodeParser;

use PhpParser\Node;
use PhpUnitGen\Model\ClassModel;
use PhpUnitGen\Model\FunctionModel;
use PhpUnitGen\Model\ModelInterface\InterfaceModelInterface;
use PhpUnitGen\Model\ModelInterface\PhpFileModelInterface;
use PhpUnitGen\Model\PropertyInterface\ClassLikeInterface;
use PhpUnitGen\Parser\NodeParser\NodeParserInterface\FunctionNodeParserInterface;
use PhpUnitGen\Parser\NodeParser\NodeParserInterface\MethodNodeParserInterface;
use PhpUnitGen\Parser\NodeParser\NodeParserInterface\ParameterNodeParserInterface;
use PhpUnitGen\Parser\NodeParserUtil\DocumentationTrait;
use PhpUnitGen\Parser\NodeParserUtil\MethodVisibilityTrait;

/**
 * Class MethodNodeParser.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
class MethodNodeParser extends AbstractNodeParser implements MethodNodeParserInterface
{
    use DocumentationTrait;
    use MethodVisibilityTrait;

    /**
     * @var ParameterNodeParserInterface $parameterNodeParser The parameter node parser.
     */
    protected $parameterNodeParser;

    /**
     * MethodNodeParser constructor.
     *
     * @param ParameterNodeParserInterface $parameterNodeParser The parameter node parser.
     */
    public function __construct(ParameterNodeParserInterface $parameterNodeParser)
    {
        $this->parameterNodeParser = $parameterNodeParser;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(Node\Stmt\ClassMethod $node, InterfaceModelInterface $parent): InterfaceModelInterface
    {
        $function = new FunctionModel();
        $function->setParentNode($parent);
        $function->setName($node->name);
        $function->setDocumentation($this->getDocumentation($node));
        $function->setIsFinal($node->isFinal());
        $function->setIsStatic($node->isStatic());
        $function->setIsAbstract($node->isAbstract());
        $function->setVisibility($this->getMethodVisibility($node));

        foreach ($node->getParams() as $param) {
            $function = $this->parameterNodeParser->invoke($param, $function);
        }

        $parent->addFunction($function);

        return $parent;
    }
}
