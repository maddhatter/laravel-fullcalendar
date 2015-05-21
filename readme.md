# Laravel 5 Full Calendar Helper

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

### Creating Events

#### Using `event()`:
The simpliest way to create an event is to pass the event information to `Calendar::event()`:


```php
$event = \Calendar::event(
    "Valentine's Day", //event title
    true, //full day event?
    '2015-02-14', //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
    '2015-02-14' //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
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
    public function getId();

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

### Create a Calendar
To create a calendar, in your route or controller, create your event(s), then pass them to `Calendar::addEvent()` or `Calendar::addEvents()` (to add an array of events). `addEvent()` and `addEvents()` can be used fluently (chained together). Their second parameter accepts an array of valid [FullCalendar Event Object parameters](http://fullcalendar.io/docs/event_data/Event_Object/).

#### Sample Controller code:

```php
$events = [];

$events[] = \Calendar::event(
    0, //event id
    'Event One', //event title
    false, //full day event?
    '2015-02-11T0800', //start time (you can also use Carbon instead of DateTime)
    '2015-02-12T0800' //end time (you can also use Carbon instead of DateTime)
);

$events[] = \Calendar::event(
    1, //event id
    "Valentine's Day", //event title
    true, //full day event?
    new \DateTime('2015-02-14'), //start time (you can also use Carbon instead of DateTime)
    new \DateTime('2015-02-14') //end time (you can also use Carbon instead of DateTime)
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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.print.css"/>

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
