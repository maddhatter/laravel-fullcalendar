<?php namespace MaddHatter\LaravelFullcalendar;

use DateTime;

/**
 * Class SimpleEvent
 *
 * Simple DTO that implements the Event interface
 *
 * @package MaddHatter\LaravelFullcalendar
 */
class SimpleEvent implements Event
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var
     */
    public $title;

    /**
     * @var bool
     */
    public $isAllDay;

    /**
     * @var DateTime
     */
    public $start;

    /**
     * @var DateTime
     */
    public $end;

    /**
     * @var string
     */
    public $color;

    /**
     * @var string
     */
    public $url;

    /**
     * @param int             $id
     * @param string          $title
     * @param bool            $isAllDay
     * @param string|DateTime $start If string, must be valid datetime format: http://bit.ly/1z7QWbg
     * @param string|DateTime $end   If string, must be valid datetime format: http://bit.ly/1z7QWbg
     * @param string          $color
     * @param string          $url
     */
    public function __construct($title, $isAllDay, $start, $end, $id = null, $color = '#3a87ad', $url = null)
    {
        $this->id       = $id;
        $this->title    = $title;
        $this->isAllDay = $isAllDay;
        $this->start    = $start instanceof DateTime ? $start : new DateTime($start);
        $this->end      = $start instanceof DateTime ? $end : new DateTime($end);
        $this->color    = $color;
        $this->url      = $url;
    }

    /**
     * Get the event's id number para hacer la url
     *
     * @return int
     */
    public function getId()
    {
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
        return $this->isAllDay;
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

    /**
     * Get the color
     *
     * @return String
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get the url
     *
     * @return String
     */
    public function getUrl()
    {
        return $this->url;
    }
}