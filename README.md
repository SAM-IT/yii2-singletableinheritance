# yii2-singletableinheritance
Yii2 Single Table Inheritance (STI) using traits

The reason this is implemented as traits is to prevent developers from putting 3rd party classes in their class hierarchy.
This implementation uses 2 traits, 1 for the query class and 1 for the model class.

The query trait adds a filter based on the model class configured for the query. It implements the `prepare()` function.
In case you use this trait on a class that also implements the `prepare()` function you MUST manually call ours like this:
```php
class MyQuery extends \yii\db\ActiveQuery 
{
    use \SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceQueryTrait;

    public function prepare($builder) 
    {
        // Your own code here
        $this->prepareSingleTableInheritance();
        // Your own code here
        return parent::prepare($builder);
    }
}
```

The model trait is a bit more complicated but still has a small surface of interaction with your code. It uses the `init()`
function, so if you override that in the base STI class (the one where you use the trait) you must call our init function:
```php
class Transport extends \yii\db\ActiveRecord 
{
    use \SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceTrait;
    public function init(): void 
    {
        self::initSingleTableInheritance($this);
    } 
}
``` 

Configure your inheritance config by implementing a static function:
```php
class Transport extends \yii\db\ActiveRecord 
{
    use \SamIT\Yii2\SingleTableInheritance\SingleTableInheritanceTrait;
    private static function inheritanceConfig(): array
    {
        return [
            'column' => 'type',
            'map' => [
                Car::class => 'car',
                Bike::class => 'bike'
            ]    
        ];       
    }
}
```
This function is only called once and its results are cached.