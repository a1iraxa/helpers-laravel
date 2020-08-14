<?php

/**
 * Dummuy Facade
 */
class CustomFacade
{

    public static function __callStatic($name, $args)
    {
        return app()->make( static::getFacadeAccessor() )->$name();
    }

    public static function getFacadeAccessor()
    {}
}

/**
 * Car
 */
class Car
{
    public function get_model()
    {
        return 2020;
    }
    public function get_color()
    {
        return 'black';
    }
    public function get_type()
    {
        return 'office use';
    }
}

app()->bind( 'car', function (){
    return new Car();
});

/**
 * Vehicle
 */
class Vehicle extends CustomFacade
{
    public static function getFacadeAccessor()
    {
        return 'car';
    }
}

echo Vehicle::get_type();
echo Vehicle::get_color();
dd(Vehicle::get_model());
