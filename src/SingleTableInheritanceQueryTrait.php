<?php

namespace SamIT\Yii2\SingleTableInheritance;

/**
 * Trait SingleTableInheritanceQueryTrait
 * This trait will automatically add a type filter during `prepare()`. If you define a prepare method in the class that
 * uses this trait make sure to call `prepareSingleTableInheritance()`.
 * The using class should be an ActiveQuery class
 * @package SamIT\Yii2\SingleTableInheritance
 */
trait SingleTableInheritanceQueryTrait
{
    /**
     * @var string
     */
    public $modelClass;
    abstract public function andFilterWhere(array $condition);

    final protected function prepareSingleTableInheritance(): void
    {
        $modelClass = $this->modelClass;
        $this->andFilterWhere([$modelClass::getInheritanceColumn() => $modelClass::getTypeFromClass($modelClass)]);
    }


    public function prepare($builder)
    {
        $this->prepareSingleTableInheritance();
        return parent::prepare($builder);
    }
}
