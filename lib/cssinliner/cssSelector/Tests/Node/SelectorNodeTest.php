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

use cssSelector\Node\ElementNode;
use cssSelector\Node\SelectorNode;

class SelectorNodeTest extends AbstractNodeTest
{
    public function getToStringConversionTestData()
    {
        return array(
            array(new SelectorNode(new ElementNode()), 'Selector[Element[*]]'),
            array(new SelectorNode(new ElementNode(), 'pseudo'), 'Selector[Element[*]::pseudo]'),
        );
    }

    public function getSpecificityValueTestData()
    {
        return array(
            array(new SelectorNode(new ElementNode()), 0),
            array(new SelectorNode(new ElementNode(), 'pseudo'), 1),
        );
    }
}
