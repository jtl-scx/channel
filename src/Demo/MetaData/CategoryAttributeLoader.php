<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/27/20
 */

namespace JTL\SCX\Channel\Demo\MetaData;


use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataCategoryAttributeLoader;
use JTL\SCX\Lib\Channel\MetaData\Attribute\Attribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeType;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;

class CategoryAttributeLoader implements MetaDataCategoryAttributeLoader
{

    public function fetch(array $categoryIdList = null): ?CategoryAttributeList
    {
        $categoryAttributeList = new CategoryAttributeList();
        foreach ($categoryIdList as $categoryId) {

            $attributeList = new AttributeList();
            foreach ($this->loadAttributesById($categoryId) as $attribute) {
                $attribute = new Attribute(
                    $attribute['id'],
                    $attribute['name'],
                    null,
                    true,
                    null,
                    AttributeType::SMALLTEXT()
                );
                $attributeList->add($attribute);
            }
        }

        return $categoryAttributeList;
    }

    private function loadAttributesById(string $categoryId): array
    {
        // You may load Attribute from somewhere else and not using a
        // static array

        return [
            ['id' => 'ATTR_0001', 'name' => 'Attribute 0001'],
            ['id' => 'ATTR_0002', 'name' => 'Attribute 0002'],
            ['id' => 'ATTR_0003', 'name' => 'Attribute 0003'],
        ];
    }
}
