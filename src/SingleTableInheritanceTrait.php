<?php

namespace SamIT\Yii2\SingleTableInheritance;

use yii\db\ActiveQueryInterface;

trait SingleTableInheritanceTrait
{
    abstract public function setAttribute($name, $value);

    /**
     * @var string
     */
    private static $typeColumn;

    /**
     * @var string[]
     */
    private static $classToType;
    /**
     * @var string[]
     */
    private static $typeToClass;

    /**
     * Returns an array with keys 'map' and 'column'
     * where 'map' contains a map of type => class
     * and 'column' contains the column name
     * [
     *      'map' => [
     *          \app\Car::class => 'car'
     *      ],
     *      'column' => 'type'
     * ]
     * This function should return the same map every time
     * @return array
     */
    private static function inheritanceConfig(): array
    {
        throw new \Exception('Inheritance config must be implemented');
    }

    private static function initCache(): void
    {
        if (!isset(self::$typeColumn)) {
            $config = self::inheritanceConfig();
            self::$typeColumn = $config['column'];
            self::$classToType = $config['map'];
            self::$typeToClass = array_flip($config['map']);
        }
    }

    /**
     * @param $class
     * @return string|null
     * @throws \Exception
     */
    final public static function getTypeFromClass($class): ?string
    {
        if ($class === self::class) {
            return null;
        }
        self::initCache();
        return self::$classToType[$class] ?? self::getTypeFromClass(get_parent_class($class));
    }

    /**
     * @return string
     */
    final public static function getInheritanceColumn(): string
    {
        self::initCache();
        return self::$typeColumn;
    }

    public function init(): void
    {
        self::initSingleTableInheritance($this);
        parent::init();
    }

    /**
     * @param array $row The attributes for the row. We don't use a param type hint because the base class doesn't
     */
    public static function instantiate($row): self
    {
        return self::instantiateSingleTableInheritance($row);
    }

    private static function getClassFromType(?string $type): string
    {
        self::initCache();
        return self::$typeToClass[$type] ?? self::class;
    }

    private static function initSingleTableInheritance(self $model): void
    {
        $model->setAttribute(self::getInheritanceColumn(), self::getTypeFromClass(static::class));
    }

    private static function instantiateSingleTableInheritance($row): self
    {
        $class = self::getClassFromType($row[self::$typeColumn] ?? null);
        return new $class;
    }
}
