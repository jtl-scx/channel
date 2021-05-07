<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/24/20
 */

namespace JTL\SCX\Channel\Demo\MetaData;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader;
use JTL\SCX\Lib\Channel\MetaData\Category;
use JTL\SCX\Lib\Channel\MetaData\CategoryList;

class CategoryTreeLoader implements MetaCategoryLoader
{
    public function fetchAll(): CategoryList
    {
        $categoryList = new CategoryList();

        // 1. fetch category tree - from channel
        $categories = [
            ['id' => 'CAT1', 'name' => 'Category A', 'parentId' => '0', 'listingAllowed' => false],
            ['id' => 'CAT2', 'name' => 'Category A', 'parentId' => 'CAT1', 'listingAllowed' => true]
        ];

        // 2. build a categoryList
        foreach ($categories as $category) {
            $id = $category["id"];
            $name = $category["name"];
            $parentId = $category["parentId"];
            $listingAllowed = $category["listingAllowed"];

            $categoryList->add(new Category($id, $name, $parentId, $listingAllowed));
        }

        return $categoryList;
    }
}
