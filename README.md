# Laravel Extended Commands

Extends the Laravel artisan commands for developers.

With all of the helpful commands that Laravel comes out of the box with, there are a few that are missing. Hopefully one day Laravel will add them officially. Until then, let's fill the gap.

## Installation

Install as a dev dependency:

```bash
composer require wadeshuler/laravel-extended-commands --dev
```

## Usage

This package is only usable via the command line. Refer to the commands list below for supported commands and how to use them.

## Commands

The make commands will generate files in the corresponding directories within the `app` directory and the `App` namespace.

**For example:** Actions will be generated in the `app/Actions` directory and will be within the `App\Actions` namespace. Enums will be generated in `app/Enums` with the `App\Enums` namespace. Contracts will be generated in `app/Contracts` with the `App\Contracts` namespace. And so on.

Using double backslashes in the name will generate sub-directories. ie, running `php artisan make:action User\\AddBlogComment` will create `app/Actions/User/AddBlogComment.php` with the namespace of `App\Actions\User`.

All of the "make" commands follow this convention.

This does not force any naming conventions on you. What you enter is what you get. If you want your contracts to end with `Contract` then you must enter it as the name, ie: `CreatesNewBlogPostContract`. If you want Enums to end with "Enum", name it like `BlogPostStatusEnum`. Personally, I don't think it's necessary to add "Contract" or "Enum" or anything to the end of most of these, as they are already included in the path and namespace and Laravel doesn't seem to do it themselves. I do like to add "Service" to the end of my services, but to each their own :)

The following list of actions/commands are supported:

### Clear Logs

Delete all of the `*.log` files found in the `storage/logs` directory:

`php artisan clear:logs`

### Make Action

`php artisan make:action SomeAction`

**Example:** `php artisan make:action AddBlogPost`

By default, this will generate "invokable actions", which allows you to typhint the action in your method and use it's parameter as a function/method. I find this the best use-case for actions and Laravel Fortify uses them mostly like this as well, which is why it's the default.

```php
public function store(Request $request, AddBlogPost $addBlogPostAction)
{
    $blogPost = $addBlogPostAction($request, $user);

    // ...
}
```

If you don't want invokable actions, you can pass a `--handle` option which creates a `handle()` method instead of the `__invoke()` magic method. This is ideal for when your actions are being used within Pipelines, which is why it automatically has the `$request` and `$next` params.

### Make Contract

`php artisan make:contract SomeContract`

**Example:** `php artisan make:contract BlogSystem`

### Make Enum

`php artisan make:enum SomeEnum`

**Example:** `php artisan make:enum BlogPostStatus`

**Enums require PHP version 8.1 or higher.**

**Note:** The generated enum is just an example of a basic active/inactive status using an integer. It will cast the status as 1 or 0 in/out of the database and includes a label method for converting it to a string representation (ie: for a dropdown in your view). It can be any valid enum type, integer is just provided as a starting example.

### Make Service

`php artisan make:service SomeService`

**Example:** `php artisan make:service BlogPostService`

**What is a service?** Services are basically a fancy name for a specialized helper class. This isn't to be confused with a Service Provider. It allows you to get a lot of your code out of the controller, improving readability, and allows you to write more fine-grained tests without repeating code. If an Action or Job isn't applicable, you may want to use a Service.

### Make Trait

`php artisan make:trait SomeTrait`

**Example:** `php artisan make:trait BlogPost`

## Custom Stubs

You can override the stubs and use your own for file generation. Refer to the stubs included in this project's source code.

It will first look in `/app/Console/stubs/` to see if the stub exists. If not, it will use the default ones provided by this package. So simply copy the stub from this package to `/app/Console/stubs/` and modify it to your liking.

## Requirements

This package requires Laravel 8 or higher. It should work with whatever PHP version you are running that satisfies your Laravel version, which is most likely PHP v7.3 or higher.

Enums, however, require PHP 8.1 or higher.

## Contributing

Contributions are welcome. Keep in mind, the goal of this package is to add additional commands that Laravel should come out of the box with, but for some reason, doesn't. I don't want to over complicate this and add all kinds of extra features.

Laravel has many "make" commands already... but why does it still not make traits, actions, or contracts? They are all used in their official packages.
