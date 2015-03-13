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
        return array_merge([
            'title' => $event->getTitle(),
            'allDay' => $event->isAllDay(),
            'start' => $event->getStart()->format('c'),
            'end' => $event->getEnd()->format('c'),
        ], $customAttributes);
    }


}