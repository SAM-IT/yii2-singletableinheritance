<?php
declare(strict_types=1);

namespace SamIT\Yii2\SingleTableInheritance\Tests\Stubs;

use SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceQueryTrait;

abstract class Query extends BaseQuery
{
    use SingleTableInheritanceQueryTrait;
}
