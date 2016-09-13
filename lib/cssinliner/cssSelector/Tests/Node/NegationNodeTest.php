<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace cssSelector\Tests\Node;

use cssSelector\Node\ClassNode;
use cssSelector\Node\NegationNode;
use cssSelector\Node\ElementNode;

class NegationNodeTest extends AbstractNodeTest
{
    public function getToStringConversionTestData()
    {
        return array(
            array(new NegationNode(new ElementNode(), new ClassNode(new ElementNode(), 'class')), 'Negation[Element[*]:not(Class[Element[*].class])]'),
        );
    }

    public function getSpecificityValueTestData()
    {
        return array(
            array(new NegationNode(new ElementNode(), new ClassNode(new ElementNode(), 'class')), 10),
        );
    }
}
