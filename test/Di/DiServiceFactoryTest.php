<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\ServiceManager\Di;

use Zend\ServiceManager\Di\DiServiceFactory;

/**
 * @group Zend_ServiceManager
 */
class DiServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DiServiceFactory
     */
    protected $diServiceFactory = null;

    /**@#+
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockDi = null;
    protected $mockServiceLocator = null;
    /**@#-*/

    protected $fooInstance = null;

    public function setup()
    {
        $instanceManager = new \Zend\Di\InstanceManager();
        $instanceManager->addSharedInstanceWithParameters(
            $this->fooInstance = new \stdClass(),
            'foo',
            ['bar' => 'baz']
        );
        $this->mockDi = $this->getMock('Zend\Di\Di', [], [null, $instanceManager]);
        $this->mockServiceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->diServiceFactory = new DiServiceFactory(
            $this->mockDi,
            'foo',
            ['bar' => 'baz']
        );
    }

    /**
     * @covers Zend\ServiceManager\Di\DiServiceFactory::__construct
     */
    public function testConstructor()
    {
        $instance = new DiServiceFactory(
            $this->getMock('Zend\Di\Di'),
            'string',
            ['foo' => 'bar']
        );
        $this->assertInstanceOf('Zend\ServiceManager\Di\DiServiceFactory', $instance);
    }

    /**
     * @covers Zend\ServiceManager\Di\DiServiceFactory::createService
     * @covers Zend\ServiceManager\Di\DiServiceFactory::get
     */
    public function testCreateService()
    {
        $foo = $this->diServiceFactory->createService($this->mockServiceLocator);
        $this->assertEquals($this->fooInstance, $foo);
    }
}
