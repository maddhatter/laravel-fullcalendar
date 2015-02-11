# Laravel 4.2 Full Calendar Helper

This is a simple helper package to make generating [http://fullcalendar.io](http://fullcalendar.io) in Laravel apps easier.

## Installing
Require the package with composer using the following command:

    composer require maddhatter/laravel-fullcalendar

Or add the following to your composer.json's require section and `composer update`

```json
"require": {
	"maddhatter/laravel-fullcalendar": "dev-master"
}
```

Then register the service provider in your `app.php` config file:

```php
'MaddHatter\LaravelFullcalendar\ServiceProvider',
```

And optionally create an alias:

```php
'Calendar' => 'MaddHatter\LaravelFullcalendar\Facades\Calendar',

```

You will also need to include [fullcalendar.io](http://fullcalendar.io/)'s files in your HTML.

## Usage
You can either choose to implement the `MaddHatter\LaravelFullcalendar\Event` interface on classes you with to pass to a calendar (such as Eloquent models), or use the `MaddHatter\LaravelFullcalendar\SimpleEvent` DTO to create events.

### Implement Interface on Eloquent Model
  
```php
class Event extends Eloquent implements \MaddHatter\LaravelFullcalendar\Event
{

    protected $dates = ['start', 'end'];

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return (bool)$this->all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
}
```

