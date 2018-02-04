<?php

namespace PhpUnitGen\Parser\NodeParser;

use PhpParser\Node;
use PhpUnitGen\Exception\AnnotationParseException;
use PhpUnitGen\Model\ModelInterface\PhpFileModelInterface;
use PhpUnitGen\Model\TraitModel;
use PhpUnitGen\Parser\NodeParserUtil\ClassLikeNameTrait;

/**
 * Class TraitNodeParser.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
class TraitNodeParser extends AbstractNodeParser
{
    use ClassLikeNameTrait;

    /**
     * @var DocumentationNodeParser $documentationNodeParser The documentation node parser to use.
     */
    private $documentationNodeParser;

    /**
     * TraitNodeParser constructor.
     *
     * @param MethodNodeParser        $methodNodeParser        The method node parser to use.
     * @param AttributeNodeParser     $attributeNodeParser     The attribute node parser to use.
     * @param DocumentationNodeParser $documentationNodeParser The documentation node parser to use.
     */
    public function __construct(
        MethodNodeParser $methodNodeParser,
        AttributeNodeParser $attributeNodeParser,
        DocumentationNodeParser $documentationNodeParser
    ) {
        $this->nodeParsers[Node\Stmt\ClassMethod::class] = $methodNodeParser;
        $this->nodeParsers[Node\Stmt\Property::class]    = $attributeNodeParser;
        $this->documentationNodeParser                   = $documentationNodeParser;
    }

    /**
     * Parse a node to update the parent node model.
     *
     * @param Node\Stmt\Trait_      $node   The node to parse.
     * @param PhpFileModelInterface $parent The parent node.
     *
     * @return PhpFileModelInterface The updated parent.
     *
     * @throws AnnotationParseException If an annotation can not be parsed.
     */
    public function invoke(Node\Stmt\Trait_ $node, PhpFileModelInterface $parent): PhpFileModelInterface
    {
        $trait = new TraitModel();
        $trait->setParentNode($parent);
        $trait->setName($this->getName($node));
        $parent->addConcreteUse($parent->getFullNameFor($trait->getName()), $trait->getName());

        if (($documentation = $node->getDocComment()) !== null) {
            $trait = $this->documentationNodeParser->invoke($documentation, $trait);
        }

        $trait = $this->parseSubNodes($node->stmts, $trait);

        $parent->addTrait($trait);

        return $parent;
    }
}
