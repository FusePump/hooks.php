# Hooks

Hooks class to add and call hooks.

# Installation

```
{
    "require": {
        "fusepump/hooks": "0.1.*"
    }
}
```
Then run:

    composer install

And finally add `require 'vendor/autoload.php'` to your php file;

# Example

```php
$hooks = new \FusePump\Hooks\Hooks();
$hooks->addHook('foo', function ($param) {
    echo $param;
});

// inside a function

$hooks->callHook('foo', 'bar');
```

The class follows a singleton pattern so the instance can be obtained globally

```php
$hooks = new \FusePump\Hooks\Hooks();
$hooks->addHook('foo', function ($param) {
    echo $param;
});

// inside a function

$hooks = \FusePump\Hooks\Hooks::getInstance();
$hooks->callHook('foo', 'bar');
```

## License

MIT
