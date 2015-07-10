<?php namespace MaddHatter\LaravelFullcalendar;

use DateTime;

interface Event
{

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay();

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart();

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd();
    
    /**
     * Get the id of the event
     *
     * @return Integer
     */
    public function getId();
    /**
     * Get the color of the event
     *
     * @return String
     */
    public function getColor();
    /**
     * Get the url of the event
     *
     * @return String
     */
    public function getUrl();

}