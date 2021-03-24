# php-8-routing
Static routing class using PHP 8 components

### Special thanks to [SteamPixel](https://github.com/steampixel)
This routing system is based on [SteamPixels routing system](https://github.com/steampixel/simplePHPRouter)

### Features
*Router*
 - Register new routes
 - Run router

*Extension*
 - Attribute to put above function and classes
 - Demo application class for custom MVC routing

### Register a new route
The `register` accepts 3 paramers.

| Name | Optional | Type |
| --- | --- | --- |
| `$path` | No | String |
| `$function` | No | Callable OR Array(class, function) |
| `$method` | Yes | String OR Array ('POST', 'GET') |

Register it manually
```php
Router::register('/',
function () {
    echo "Hello World"; // Echo's "Hello World" on your screen
}, 
'POST'); 
```

---

Or using the attribute, which you can later find with the PHP ReflectionAPI

```php
class MyClass {
    #[Route('/')]
    function MyFunction() {
        echo "Hello World";
    }
}
```
View the [MVC Demo](/Demo/MVC) for full demo, or look into the [MVC Application class](/Demo/MVC/Core/Application.php) to see how the attributes are read.

