<?php namespace MaddHatter\LaravelFullcalendar;

use Illuminate\View\Factory;

class Calendar
{

    /**
     * @var Factory
     */
    protected $view;

    /**
     * @var EventCollection
     */
    protected $eventCollection;

    /**
     * @var string
     */
    protected $id;

    /**
     * @param Factory         $view
     * @param EventCollection $eventCollection
     */
    public function __construct(Factory $view, EventCollection $eventCollection)
    {
        $this->view            = $view;
        $this->eventCollection = $eventCollection;
    }

    public function calendar()
    {
        return '<div id="calendar-' . $this->getId() . '"></div>';
    }

    public function script()
    {
        return $this->view->make('fullcalendar::script', [
            'id' => $this->getId(),
            'events' => $this->eventCollection->toJson(),
        ]);
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        if ( ! empty($this->id)) {
            return $this->id;
        }

        $this->id = str_random(8);

        return $this->id;
    }

    /**
     * Add an event
     *
     * @param Event $event
     * @param array $customAttributes
     * @return $this
     */
    public function addEvent(Event $event, array $customAttributes = [])
    {
        $this->eventCollection->push($event, $customAttributes);

        return $this;
    }

    public function addEvents(array $events, array $customAttributes = [])
    {
        foreach ($events as $event) {
            $this->eventCollection->push($event, $customAttributes);
        }

        return $this;
    }
}