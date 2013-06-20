<?php
/**
 * Hooks test
 *
 * @author Jonathan Kim <jonathan.kim@fusepump.com>
 */
require_once __DIR__.'/../src/FusePump/Hooks/Hooks.php';
use \FusePump\Hooks\Hooks as Hooks;
/**
 * Hooks test
 *
 * @author Jonathan Kim <jonathan.kim@fusepump.com>
 */
class HooksTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test creation of class from static method
     *
     * @return void
     */
    public function testSingletonCreation()
    {
        Hooks::setInstance(null);
        $hooks = Hooks::getInstance();

        $this->assertInstanceOf('\FusePump\Hooks\Hooks', $hooks);
    }

    /**
     * Test singleton
     *
     * @return void
     */
    public function testSingleton()
    {
        $hooks = new Hooks();

        $hooks2 = Hooks::getInstance();

        $this->assertEquals($hooks, $hooks2);
    }

    /**
     * Test adding hook
     *
     * @return void
     */
    public function testAddHook()
    {
        $hooks = new Hooks();

        $func = function () {
            return 'bar';
        };

        $hooks->addHook('foo', $func);

        $hooksArray = $hooks->getHooks();
        $this->assertEquals($hooksArray['foo'][0], $func);
    }

    /**
     * Test adding non callable hook
     *
     * @return void
     */
    public function testAddHookNonCallable()
    {
        $hooks = new Hooks();

        $this->setExpectedException(
            'Exception', 'Hook function is not callable'
        );
        $hooks->addHook('foo', 'bar');
    }

    /**
     * Test add hook chaining
     *
     * @return void
     */
    public function testAddHookChaining()
    {
        $hooks = new Hooks();

        $func = function () {
            return 'bar';
        };

        $func2 = function () {
            return 'zzz';
        };

        $hooks->addHook('foo', $func)
            ->addHook('aaa', $func2);

        $hooksArray = $hooks->getHooks();
        $this->assertEquals($hooksArray['foo'][0], $func);
        $this->assertEquals($hooksArray['aaa'][0], $func2);
    }

    /**
     * Test call hook
     *
     * @return void
     */
    public function testCallHook()
    {
        $hooks = new Hooks();

        $test = $this;
        $func = function ($input) use ($test) {
            $test->assertEquals('bar', $input);
        };

        $hooks->addHook('foo', $func);

        $hooks->callHook('foo', 'bar');
    }
}
