<?php
/**
 * Hooks
 *
 * @author Jonathan Kim <jonathan.kim@fusepump.com>
 */
namespace FusePump\Hooks;
/**
 * Hooks
 *
 * @author Jonathan Kim <jonathan.kim@fusepump.com>
 */
class Hooks
{
    protected static $instance = null;
    protected $hooks = array();

    /**
     * Constructor
     */
    public function Hooks()
    {
        self::$instance = $this;
    }

    /**
     * Get instance
     *
     * @return instance
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Hooks();
        }
        return self::$instance;
    }

    /**
     * Set instance
     *
     * @param object $instance - instance object to set
     *
     * @return void
     */
    public static function setInstance($instance)
    {
        self::$instance = $instance;
    }

    /**
     * Add hook
     *
     * @param function $key  - hook name
     * @param function $func - function to call
     *
     * @return this
     */
    public function addHook($key, $func)
    {
        if (!is_callable($func)) {
            throw new \Exception('Hook function is not callable');
        }

        if (!array_key_exists($key, $this->hooks)) {
            $this->hooks[$key] = array();
        }

        $this->hooks[$key][] = $func;

        return $this;
    }

    /**
     * Call hook
     *
     * @param string $key - hook name
     *
     * @return void
     */
    public function callHook($key)
    {
        if (array_key_exists($key, $this->hooks)) {
            // Get function arguments
            $args = func_get_args();
            unset($args[0]);

            foreach ($this->hooks[$key] as $hook) {
                call_user_func_array($hook, $args);
            }
        }
    }

    /**
     * Get hooks
     *
     * @return array hooks
     */
    public function getHooks()
    {
        return $this->hooks;
    }
}
