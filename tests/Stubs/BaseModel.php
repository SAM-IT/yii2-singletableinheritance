<?php
declare(strict_types=1);

namespace SamIT\Yii2\SingleTableInheritance\Tests\Stubs;

class BaseModel
{

    public function setAttribute($name, $value)
    {
        throw new \Exception('Stub plz');
    }

    public function init()
    {
    }
}
