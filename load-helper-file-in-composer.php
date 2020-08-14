{
    "name": "laravel/Helpers",
    "description": "The Laravel Framework Helpers.",
    "keywords": ["helpers", "laravel"],
    "license": "MIT",
    "type": "project",
    "require": {
        "php": ">=5.6.4",
        "barryvdh/laravel-debugbar": "^2.4",
        "cmgmyr/messenger": "^2.15",
        "devmarketer/easynav": "^1.0",
        "intervention/image": "^2.4",
        "laravel/framework": "5.4.*",
        "laravel/tinker": "~1.0",
        "laravelcollective/html": "^5.2.0",
        "lord/laroute": "^2.4",
        "plank/laravel-mediable": "^2.5",
        "pusher/pusher-php-server": "~2.6",
        "santigarcor/laratrust": "5.0.*",
        "unisharp/laravel-ckeditor": "^4.7",
        "yajra/laravel-datatables-oracle": "^6.0"
    },
    "autoload": {
        "classmap": [
            "database/seeds",
            "database/factories"
        ],
        "psr-4": {
            "App\\": "app/"
        },
        "files": [
            "app/Http/Helpers/functions.php" // Create your file and add here...
        ]
    }
}
