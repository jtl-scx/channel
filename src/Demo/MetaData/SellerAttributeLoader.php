<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/4/20
 */

namespace JTL\SCX\Channel\Demo\MetaData;

use JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader as SellerAttributeLoaderInterface;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;

class SellerAttributeLoader implements SellerAttributeLoaderInterface
{
    public function fetchAll(string $sellerId): AttributeList
    {
        return new AttributeList();
    }
}
