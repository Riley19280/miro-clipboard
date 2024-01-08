<?php

namespace MiroClipboard\Parsers;

use MiroClipboard\Objects\MiroGroup;

class GroupParser implements MiroParserInterface
{
    public static function parse(array $data): MiroGroup
    {
        $newGroup = MiroGroup::make()
            ->id($data['id'])
            ->initialId($data['initialId']);

        foreach ($data['items'] as $id) {
            $newGroup->add($id);
        }

        return $newGroup;
    }
}
