<?php

namespace lukaszmakuch\SfContainerHaringoVal;

use lukaszmakuch\Haringo\Builder\Impl\HaringoBuilderImpl;
use lukaszmakuch\Haringo\BuildPlan\Impl\NewInstanceBuildPlan;
use lukaszmakuch\Haringo\ClassSource\Impl\ExactClassPath;
use lukaszmakuch\Haringo\Haringo;
use lukaszmakuch\Haringo\MethodCall\MethodCall;
use lukaszmakuch\Haringo\MethodSelector\Impl\ConstructorSelector;
use lukaszmakuch\Haringo\ParamSelector\Impl\ParamByPosition;
use lukaszmakuch\Haringo\ParamValue\AssignedParamValue;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TestClass
{
    public function __construct ($val) { $this->val = $val; }
}

class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Haringo
     */
    private $haringo;
    
    protected function setUp()
    {
        $haringoBuilder = new HaringoBuilderImpl();
        $this->haringo = $haringoBuilder->build();
    }
    
    public function testResolvingValues()
    {
        $container = new ContainerBuilder();
        $container->set("value_from_the_container", 123);
        
        $buildPlan = (new NewInstanceBuildPlan())
            ->setClassSource(new ExactClassPath(TestClass::class))
            ->addMethodCall((new MethodCall(ConstructorSelector::getInstance()))
                ->assignParamValue(new AssignedParamValue(
                    new ParamByPosition(0), 
                    new InjectedValue("value_from_the_container")
                ))
            );
        
        /* @var $builtObject TestClass */
        $builtObject = $this->haringo->buildObjectBasedOn($buildPlan);
        $this->assertEquals(123, $builtObject->val);
    }
    
    
}