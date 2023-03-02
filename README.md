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

- If you want your model to have timestamps, use trait `App\Traits\HasTimestamps` in your model (view example in `User` model). Project's old
  structure require timestamps to be stored as Epoch. Btw these funcs will convert dates output for you as a `Carbon`
  instance
- If you wish your route to display at header menu, add it to `routes` const at `AuthenticatedLayout.vue` following
  the example
- For a table for an entity you should use `@/Components/Common/DataTable.vue`. Find example at any entity's index
  component

### Authentication

The default laravel auth is left 99% untouched, here's couple inevitably required changes since we're using old DB:

- `users` table renamed to `user`
- `name` field is removed from users table
- `username`, `status` and `logged_at` are the new columns
- *!needsToBeSpecified* `status` is an Enum you can find values and descriptions for in `Enums\UserStatusEnum`
- `updated_at`, `created_at` and `logged_at` are stored in Epoch format
- Registration is only available when environment is

> APP_ENV=local <br/>
> APP_DEBUG=true

### Orders

Relations:

- `belongsTo(Quest::class)` - `Order` is directly related to `Quest`
- `belongsTo(Orders\OrderSource::class)` - `Order` has a `source` it came from

Some tips:

- You can find order status list at `App/Enums/OrderStatusEnum::getArray()` and use the `status` property as an enum

