<?php

/**
 * This file is part of the SfContainerHaringoVal extension.
 *
 * @author Łukasz Makuch <kontakt@lukaszmakuch.pl>
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace lukaszmakuch\SfContainerHaringoVal;

use lukaszmakuch\Haringo\Builder\Impl\HaringoBuilderImpl;
use lukaszmakuch\Haringo\BuildPlan\BuildPlan;
use lukaszmakuch\Haringo\BuildPlan\Impl\NewInstanceBuildPlan;
use lukaszmakuch\Haringo\ClassSource\Impl\ExactClassPath;
use lukaszmakuch\Haringo\Haringo;
use lukaszmakuch\Haringo\MethodCall\MethodCall;
use lukaszmakuch\Haringo\MethodSelector\Impl\ConstructorSelector;
use lukaszmakuch\Haringo\ParamSelector\Impl\ParamByPosition;
use lukaszmakuch\Haringo\ParamValue\AssignedParamValue;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TestClass
{
    public function __construct ($val) { $this->val = $val; }
}

class ExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Haringo
     */
    private $haringo;
    
    /**
     * @var Container 
     */
    private $container;
    
    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        
        $haringoBuilder = new HaringoBuilderImpl();
        $ext = $this->getExtension($this->container);
        $haringoBuilder->addValueSourceExtension($ext);
        $this->haringo = $haringoBuilder->build();
    }
    
    public function testResolvingValues()
    {
        $this->container->set("value_from_the_container", 123);
        
        $buildPlan = $this->getBuildPlanOfObjectUsing("value_from_the_container");
        
        /* @var $builtObject TestClass */
        $builtObject = $this->haringo->buildObjectBasedOn($buildPlan);
        $this->assertEquals(123, $builtObject->val);
    }
    
    public function testExceptionIfWrongKey()
    {
        $this->setExpectedException(\lukaszmakuch\Haringo\Exception\UnableToBuild::class);
        $buildPlan = $this->getBuildPlanOfObjectUsing("wrong_key");
        $this->haringo->buildObjectBasedOn($buildPlan);
    }
    
    public function testMapping()
    {
        $this->container->set("value_from_the_container", 123);
        
        $plan = $this->getBuildPlanOfObjectUsing("value_from_the_container");

        $serializedPlan = $this->haringo->serializeBuildPlan($plan);
        $unserializedPlan = $this->haringo->deserializeBuildPlan($serializedPlan);
        $builtObject = $this->haringo->buildObjectBasedOn($unserializedPlan);
        $this->assertEquals(123, $builtObject->val);
    }
    
    /**
     * Gets extension using the given container.
     * 
     * @param Container $container
     * @return InjectedValueExtension
     */
    private function getExtension(Container $container)
    {
        $f = new InjectedValueExtensionFactory();
        return $f->buildWith($container);
    }
    
    /**
     * Gets a build plan of TestClass instance with 
     * a value resolved from the container (with key equals $containerKey)
     * passed as the constructor parameter.
     * 
     * @param String $containerKey
     * @return BuildPlan 
     */
    private function getBuildPlanOfObjectUsing($containerKey)
    {
        return (new NewInstanceBuildPlan())
            ->setClassSource(new ExactClassPath(TestClass::class))
            ->addMethodCall((new MethodCall(ConstructorSelector::getInstance()))
                ->assignParamValue(new AssignedParamValue(
                    new ParamByPosition(0), 
                    new InjectedValue($containerKey)
                ))
            );
    }
}