<?php
declare(strict_types=1);

namespace SamIT\Yii2\SingleTableInheritance\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceQueryTrait;
use SamIT\Yii2\SingleTableInheritance\Tests\Stubs\Query;
use SamIT\Yii2\SingleTableInheritance\Tests\Stubs\StiSub1;

/**
 * @covers \SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceQueryTrait
 */
class QueryTraitTest extends TestCase
{
    public function testPrepare()
    {
        /** @var MockObject|SingleTableInheritanceQueryTrait $mock */
        $mock = $this->getMockForAbstractClass(Query::class);
        $mock
            ->expects($this->once())
            ->method('andFilterWhere')->with(['abc' => 'def']);


        $mock->modelClass = StiSub1::class;
        $mock->prepare(null);
    }
}
