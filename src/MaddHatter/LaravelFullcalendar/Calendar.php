<?php namespace MaddHatter\LaravelFullcalendar;

use DateTime;
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
    *
    * @var array
    *
    **/
    protected $additional;
    

    /**
     * @param Factory         $view
     * @param EventCollection $eventCollection
     */
    public function __construct(Factory $view, EventCollection $eventCollection)
    {
        $this->view            = $view;
        $this->eventCollection = $eventCollection;
        $this->additional=array();
    }

    /**
     * Create an event DTO to add to a calendar
     *
     * @param string          $title
     * @param string          $isAllDay
     * @param string|DateTime $start If string, must be valid datetime format: http://bit.ly/1z7QWbg
     * @param string|DateTime $end   If string, must be valid datetime format: http://bit.ly/1z7QWbg
     * @return SimpleEvent
     */
    public static function event($title, $isAllDay, $start, $end)
    {
        return new SimpleEvent($title, $isAllDay, $start, $end);
    }

    /**
     * Create the <div> the calendar will be rendered into
     *
     * @return string
     */
    public function calendar()
    {
        return '<div id="calendar-' . $this->getId() . '"></div>';
    }

    /**
     * Get the <script> block to render the calendar (as a View)
     *
     * @return \Illuminate\View\View
     */
    public function script()
    {
        $id=$this->getId();
        $params=$this->getParams();
        $params = json_encode($params);
        return $this->view->make('fullcalendar::script', compact('id', 'params'))->render();
    }

    /**
    *
    * Getting the parameters
    *
    * @param $items
    * @return string
    **/
    public function getParams($items=array())
    {
        $params=$this->additional;
        $params['eventLimit'] = (isset($params['eventLimit']))?$params['eventLimit']:true;
        if(isset($params['header']))
        {
            if (!is_array($params['header']))
            {
                $params['header'] = array();
                $params['header']['left'] = 'prev,next today';
                $params['header']['center'] = 'title';
                $params['header']['right'] = 'month,agendaWeek,agendaDay';
            }
            
        }
        else
        {
            $params['header'] = array();
            $params['header']['left'] = 'prev,next today';
            $params['header']['center'] = 'title';
            $params['header']['right'] = 'month,agendaWeek,agendaDay';
        }
        $params['events'] = (isset($params['events'])&&is_array($params['events']))
                                    ?array_merge($params['events'],$this->eventCollection->toArray())
                                    :$this->eventCollection->toArray();
        return $params;
    }

    /**
     * Customize the ID of the generated <div>
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the ID of the generated <div>
     * This value is randomized unless a custom value was set via setId
     *
     * @return string
     */
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

    /**
     * Add multiple events
     *
     * @param array $events
     * @param array $customAttributes
     * @return $this
     */
    public function addEvents(array $events, array $customAttributes = [])
    {
        foreach ($events as $event) {
            $this->eventCollection->push($event, $customAttributes);
        }

        return $this;
    }

    /**
    *
    * Set additional parameters
    *
    **/
    public function setAdditionalParams(array $params=array())
    {
        $this->additional=$params;
    }
    
}