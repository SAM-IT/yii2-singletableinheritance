<?php
declare(strict_types=1);

namespace SamIT\Yii2\SingleTableInheritance\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceQueryTrait;
use SamIT\Yii2\SingleTableInheritance\Tests\Stubs\InvalidStiModel;
use SamIT\Yii2\SingleTableInheritance\Tests\Stubs\Query;
use SamIT\Yii2\SingleTableInheritance\Tests\Stubs\StiModel;
use SamIT\Yii2\SingleTableInheritance\Tests\Stubs\StiSub1;
use SamIT\Yii2\SingleTableInheritance\Tests\Stubs\StiSub2;

/**
 * @coversDefaultClass  \SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceTrait
 */
class ModelTraitTest extends TestCase
{
    /**
     * @covers \SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceTrait::inheritanceConfig()
     */
    public function testNoConfig()
    {
        $this->expectException(\Exception::class);
        InvalidStiModel::getInheritanceColumn();
    }

    public function testGetInheritanceColumn()
    {
        $this->assertSame(StiSub1::getInheritanceColumn(), 'abc');
    }
    public function testGetTypeFromClass()
    {
        $this->assertSame(null, StiModel::getTypeFromClass(StiModel::class));
        $this->assertSame('def', StiModel::getTypeFromClass(StiSub1::class));
        $this->assertSame('ghi', StiModel::getTypeFromClass(StiSub2::class));
    }

    public function testInstantiate()
    {
        $this->assertInstanceOf(StiSub1::class, StiModel::instantiate(['abc' => 'def']));
        $this->assertInstanceOf(StiSub2::class, StiModel::instantiate(['abc' => 'ghi']));
        $this->assertInstanceOf(StiModel::class, StiModel::instantiate(['abc' => 'unknown']));

        $this->assertNotInstanceOf(StiSub1::class, StiModel::instantiate(['abc' => 'unknown']));
        $this->assertNotInstanceOf(StiSub2::class, StiModel::instantiate(['abc' => 'unknown']));
        $this->assertInstanceOf(StiModel::class, StiModel::instantiate(['abc' => 'unknown']));

        $this->assertNotInstanceOf(StiSub1::class, StiModel::instantiate(['abc' => null]));
        $this->assertNotInstanceOf(StiSub2::class, StiModel::instantiate(['abc' => null]));
        $this->assertInstanceOf(StiModel::class, StiModel::instantiate(['abc' => null]));

        $this->assertNotInstanceOf(StiSub1::class, StiModel::instantiate(['otherfield' => 'val']));
        $this->assertNotInstanceOf(StiSub2::class, StiModel::instantiate(['otherfield' => 'val']));
        $this->assertInstanceOf(StiModel::class, StiModel::instantiate(['otherfield' => 'val']));
    }

    /**
     * @covers \SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceTrait::init()
     * @covers \SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceTrait::initSingleTableInheritance()
     */
    public function testInit()
    {
        /** @var StiSub1|MockObject $mock */
        $mock = $this->getMockBuilder(StiSub1::class)
            ->onlyMethods(['setAttribute'])
            ->getMock();
        $mock->expects($this->once())->method('setAttribute')->with('abc', 'def');
        $mock->init();
    }
}
