<?php namespace MaddHatter\LaravelFullcalendar;

use Illuminate\Support\Collection;

class EventCollection
{

    /**
     * @var Collection
     */
    protected $events;

    public function __construct()
    {
        $this->events = new Collection();
    }

    public function push(Event $event, array $customAttributes = [])
    {
        $this->events->push($this->convertToArray($event, $customAttributes));
    }

    public function toJson()
    {
        return $this->events->toJson();
    }

    public function toArray()
    {
        return $this->events->toArray();
    }

    private function convertToArray(Event $event, array $customAttributes = [])
    {
        $eventArray = [
            'id' => $this->getEventId($event),
            'title' => $event->getTitle(),
            'allDay' => $event->isAllDay(),
            'start' => $event->getStart()->format('c'),
            'end' => $event->getEnd()->format('c'),
        ];
        
        /* On recurring events, fullcalendar requires the start and end values to just contain the time (hour:minutes)
            part of the date
        */
        if ($vOptions = $event->getEventOptions()) {
            if (isset($vOptions['ranges']) || isset($vOptions['dow'])) {
                $eventArray['start'] = $event->getStart()->format('H:i');
                $eventArray['end'] = $event->getEnd()->format('H:i');
            }
        }

        $eventOptions = method_exists($event, 'getEventOptions') ? $event->getEventOptions() : [];

        return array_merge($eventArray, $eventOptions, $customAttributes);
    }

    private function getEventId(Event $event)
    {
        if ($event instanceof IdentifiableEvent) {
            return $event->getId();
        }

        return null;
    }
}
