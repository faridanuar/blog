<?php

namespace App\Utilities\Singleton;

/*
    "Singleton class still says its the same instance even after remove if checking why?":
        
    In Laravel, the behavior you're observing is likely due to Laravel's service container, which is responsible for managing instances of classes and implementing the Singleton pattern.
    Laravel uses the service container to resolve and manage dependencies throughout your application, and it can affect how singletons are created and shared.

    If you want to ensure that you're getting a new instance of your TodaysQuote class every time you request it, you can take the following approaches:

    Use Laravel's Container: Laravel's service container is designed to manage instances of classes.
    Instead of implementing your own Singleton pattern, consider using Laravel's container to resolve instances of your class.
    This way, you can let Laravel handle the instance management for you. 
 */
class TodaysQuote
{
    private static $instance; // Private static variable to hold the single instance of the class
    private $quote;

    private function __construct()
    {
        // Private constructor to prevent direct instantiation
        $this->quote = "yo mama ".date("d/m/Y, H:i:s");
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self(); // Create a new instance only if it doesn't exist
        }

        return self::$instance;
    }

    public function get()
    {
        return $this->quote;
    }
}