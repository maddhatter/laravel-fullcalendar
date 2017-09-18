# Laravel 5 Full Calendar Helper

[![Latest Stable Version](https://poser.pugx.org/maddhatter/laravel-fullcalendar/v/stable)](https://packagist.org/packages/maddhatter/laravel-fullcalendar) [![Total Downloads](https://poser.pugx.org/maddhatter/laravel-fullcalendar/downloads)](https://packagist.org/packages/maddhatter/laravel-fullcalendar) [![Latest Unstable Version](https://poser.pugx.org/maddhatter/laravel-fullcalendar/v/unstable)](https://packagist.org/packages/maddhatter/laravel-fullcalendar) [![License](https://poser.pugx.org/maddhatter/laravel-fullcalendar/license)](https://packagist.org/packages/maddhatter/laravel-fullcalendar)

***For Laravel 4.2: use the [laravel-4 branch](https://github.com/maddhatter/laravel-fullcalendar/tree/laravel-4)***

This is a simple helper package to make generating [http://fullcalendar.io](http://fullcalendar.io) in Laravel apps easier.

## Installing
Require the package with composer using the following command:

    composer require maddhatter/laravel-fullcalendar

Or add the following to your composer.json's require section and `composer update`

```json
"require": {
	"maddhatter/laravel-fullcalendar": "~1.0"
}
```

### Laravel 5.4 (and earlier)

Register the service provider in your `app.php` config file:

```php
MaddHatter\LaravelFullcalendar\ServiceProvider::class,
```

And optionally create an alias:

```php
'Calendar' => MaddHatter\LaravelFullcalendar\Facades\Calendar::class,

```

### Laravel 5.5+
The provider and `Calendar` alias will be registered automatically.

You will also need to include [fullcalendar.io](http://fullcalendar.io/)'s files in your HTML.

## Usage

### Creating Events

#### Using `event()`:
The simpliest way to create an event is to pass the event information to `Calendar::event()`:


```php
$event = \Calendar::event(
    "Valentine's Day", //event title
    true, //full day event?
    '2015-02-14', //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
    '2015-02-14', //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
	1, //optional event ID
	[
		'url' => 'http://full-calendar.io'
	]
);
```
#### Implementing `Event` Interface

Alternatively, you can use an existing class and have it implement `MaddHatter\LaravelFullcalendar\Event`. An example of an Eloquent model that implements the `Event` interface:

```php
class EventModel extends Eloquent implements \MaddHatter\LaravelFullcalendar\Event
{

    protected $dates = ['start', 'end'];

    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId() {
		return $this->id;
	}

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

#### `IdentifiableEvent` Interface

If you wish for your existing class to have event IDs, implement `\MaddHatter\LaravelFullcalendar\IdentifiableEvent` instead. This interface extends `\MaddHatter\LaravelFullcalendar\Event` to add a `getId()` method:

```php
class EventModel extends Eloquent implements \MaddHatter\LaravelFullcalendar\IdentifiableEvent
{

	// Implement all Event methods ...

    /**
     * Get the event's ID
     *
     * @return int|string|null
     */
    public function getId();

}

```

### Additional Event Parameters

If you want to add [additional parameters](http://fullcalendar.io/docs/event_data/Event_Object) to your events, there are two options:

#### Using `Calendar::event()`

Pass an array of `'parameter' => 'value'` pairs as the 6th parameter to `Calendar::event()`:

```php
$event = \Calendar::event(
    "Valentine's Day", //event title
    true, //full day event?
    '2015-02-14', //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
    '2015-02-14', //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
	1, //optional event ID
	[
		'url' => 'http://full-calendar.io',
		//any other full-calendar supported parameters
	]
);

```

#### Add an `getEventOptions` method to your event class

```php
<?php
class CalendarEvent extends \Illuminate\Database\Eloquent\Model implements \MaddHatter\LaravelFullcalendar\Event
{
	//...

	/**
     * Optional FullCalendar.io settings for this event
     *
     * @return array
     */
    public function getEventOptions()
    {
        return [
            'color' => $this->background_color,
			//etc
        ];
    }

	//...
}

```

### Create a Calendar
To create a calendar, in your route or controller, create your event(s), then pass them to `Calendar::addEvent()` or `Calendar::addEvents()` (to add an array of events). `addEvent()` and `addEvents()` can be used fluently (chained together). Their second parameter accepts an array of valid [FullCalendar Event Object parameters](http://fullcalendar.io/docs/event_data/Event_Object/).

#### Sample Controller code:

```php
$events = [];

$events[] = \Calendar::event(
    'Event One', //event title
    false, //full day event?
    '2015-02-11T0800', //start time (you can also use Carbon instead of DateTime)
    '2015-02-12T0800', //end time (you can also use Carbon instead of DateTime)
	0 //optionally, you can specify an event ID
);

$events[] = \Calendar::event(
    "Valentine's Day", //event title
    true, //full day event?
    new \DateTime('2015-02-14'), //start time (you can also use Carbon instead of DateTime)
    new \DateTime('2015-02-14'), //end time (you can also use Carbon instead of DateTime)
	'stringEventId' //optionally, you can specify an event ID
);

$eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

$calendar = \Calendar::addEvents($events) //add an array with addEvents
    ->addEvent($eloquentEvent, [ //set custom color fo this event
        'color' => '#800',
    ])->setOptions([ //set fullcalendar options
		'firstDay' => 1
	])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
        'viewRender' => 'function() {alert("Callbacks!");}'
    ]);

return view('hello', compact('calendar'));
```


#### Sample View

Then to display, add the following code to your View:

```html
<!doctype html>
<html lang="en">
<head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>


    <style>
        /* ... */
    </style>
</head>
<body>
    {!! $calendar->calendar() !!}
    {!! $calendar->script() !!}
</body>
</html>
```
**Note:** The output from `calendar()` and `script()` must be non-escaped, so use `{!!` and `!!}` (or whatever you've configured your Blade compiler's raw tag directives as).   

The `script()` can be placed anywhere after `calendar()`, and must be after fullcalendar was included.

This will generate (in February 2015):

![](http://i.imgur.com/qjgVhCY.png)
