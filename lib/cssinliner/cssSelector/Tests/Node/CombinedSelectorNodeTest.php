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

use cssSelector\Node\CombinedSelectorNode;
use cssSelector\Node\ElementNode;

class CombinedSelectorNodeTest extends AbstractNodeTest
{
    public function getToStringConversionTestData()
    {
        return array(
            array(new CombinedSelectorNode(new ElementNode(), '>', new ElementNode()), 'CombinedSelector[Element[*] > Element[*]]'),
            array(new CombinedSelectorNode(new ElementNode(), ' ', new ElementNode()), 'CombinedSelector[Element[*] <followed> Element[*]]'),
        );
    }

    public function getSpecificityValueTestData()
    {
        return array(
            array(new CombinedSelectorNode(new ElementNode(), '>', new ElementNode()), 0),
            array(new CombinedSelectorNode(new ElementNode(null, 'element'), '>', new ElementNode()), 1),
            array(new CombinedSelectorNode(new ElementNode(null, 'element'), '>', new ElementNode(null, 'element')), 2),
        );
    }
}
