<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
Recommended setup for <a href="#">Laravel v10.1.3</a>
<br/>
<a href="#">PHP 8.1</a>
<br/>
<a href="#">Node 19.6.0</a>
<br/>
<a href="#">NPM 9.4.0</a>
</p>

# Laravel-based admin panel

## Docs

### Global

When making changes to project, please, keep in mind stuff below:

- If you wish your route to display at header menu, add it to `routes` const at `AuthenticatedLayout.vue` following
  the example
- For a table for an entity you should use `@/Components/Common/DataTable.vue`. Find example at any entity's index
  component

### Enums

All the fields in DB that contain a standalone number are actually cast as Enums, almost all of them are serializable.
Those enums can be serialized as an array. You can get a list of values by calling `getArray()` method on it. To create
one yourself:

- Implement `App\Enums\ISerializableEnum` interface to enum
- Use the `App\Traits\IsSerializableEnum` on it
- Implement `toArray()` method
- Cast required field as the created Enum in your model
  Now you can define any value from a row as an Enum, which gives you an ability to describe value more specifically

### Themes

Themes stored as serializable enum in `App\Enums\ProjectThemeEnum.php`. They are currently just used as a placeholder,
but in convenient way, so you can implement the theme mechanics when needed

### Authentication and common statements

The default laravel auth is left 99% untouched, here's couple inevitably required changes since we're using old DB:

- `users` table renamed to `user`
- `name` field is removed from users table
- `username`, `status` and `logged_at` are the new columns
- *!needsToBeSpecified* `status` is an Enum you can find values and descriptions for in `Enums\UserStatusEnum`
- `updated_at`, `created_at` and `logged_at` are stored in Epoch format
- Registration is only available when environment is

> APP_ENV=local <br/>
> APP_DEBUG=true

### Obviously bad code

To refactor:

- schedule items - schedule - quest relationship
- Database naming issues (any form request that contains `getUnRefactoredValidatedData` method)
