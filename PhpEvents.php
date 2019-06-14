<?php
class PhpEvents {

    private $events;

    // Singleton
    private static $instance = null;
    private function __construct() {
        // The expensive process (e.g.,db connection) goes here.
    }
    public static function getInstance() {
    if (self::$instance == null) {
        self::$instance = new PhpEvents();
    }
    return self::$instance;
}

    /**
     * Return a message from PHP Events
     * @param string $message, message for display
     */
    private function msg($message = "") {
        die("Php_events: {$message}");
    }

    /**
     * Check if an event exists.
     * @param $slug
     * @return bool
     */
    private function event_exists($slug) {
        return (isset($this->events[$slug]));
    }

    /**
     * Register an event in the environment.
     * @param $slug string, Unique identifier for event.
     * @param $args string, Arguments or parameters that be passed to all listeners.
     * @param $description string, Description for display in tree listeners.
     */
    public function register($slug, $args = [], $description = "") {
        if (!$this->event_exists($slug)) {
            $this->events[$slug] = [];
            $this->events[$slug]["args"] = $args;
            $this->events[$slug]["description"] = $description;
            $this->events[$slug]["listeners"] = [];
        }
        else{
            $this->msg("Event \"{$slug}\" already exists");
        }
    }

    /**
     * Starts an listener for determinate event.
     * @param $slug string, Slug for event
     * @param $callback, Function that be called when the event has been fired.
     */
    public function listen($slug, $callback) {
        if ($this->event_exists($slug)) {
            $this->events[$slug]["listeners"][] = $callback;
        }
        else{
            $this->msg("Listen \"{$slug}\" event that not exists");
        }
    }

    /**
     * Fire any event
     * @param $slug string, Slug for event.
     * @return array, Array with all responses of event listeners registered.
     */
    public function do_event($slug) {
        $arrEventsCalled = [];
        if ($this->event_exists($slug)) {
            foreach ($this->events[$slug]["listeners"] as $callback) {
                if (is_callable($callback)) {
                    $eventResponse = call_user_func($callback, $this->events[$slug]["args"]);
                }
                else {
                    $eventResponse = "Callback in \"{$slug}\" event is not a function";
                }
                $arrEventsCalled[] = $eventResponse;
            }
            return $arrEventsCalled;
        }
    }
}