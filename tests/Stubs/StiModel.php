<?php
declare(strict_types=1);

namespace SamIT\Yii2\SingleTableInheritance\Tests\Stubs;

use SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceTrait;

class StiModel extends BaseModel
{
    use SingleTableInheritanceTrait;
    private static function inheritanceConfig(): array
    {
        return [
            'map' => [
                StiSub1::class => 'def',
                StiSub2::class => 'ghi'
            ],
            'column' => 'abc'
        ];
    }
}
