<?php
namespace deschdanja\ClassBuilder;

/**
 *
 * @author Theodor
 */
interface IClassBuilder {
    /**
     * add interface that is implemented by Class
     * empty methods basing on interface will be added automatically if they don't exist
     * @param string $interface
     */
    public function addInterface($interface);
    
    /**
     * add method to class
     * @param TS_ClassBuilder_IMethod $method
     */
    public function addMethod(IMethod $method);
    
    /**
     * add parameter to this class
     * @param TS_ClassBuilder_IParameter $parameter
     */
    public function addParameter(IParameter $parameter);

    /**
     * passes dumpString to eval to declare class
     */
    public function declareClass();

    /**
     * returns string that can be used to declare class
     * @return string
     */
    public function getDumpString();
    
    /**
     * @return array containing IParameter
     */
    public function getParameters();
    
    /**
     * @return array containing IMethod
     */
    public function getMethods();
    
    /**
     * @return array containing Interface names
     */
    public function getInterfaceNames();

    /**
     * set whether class abstract or not
     * @param bool $abstract
     */
    public function setAbstract($abstract);

    /**
     * set name of class
     * @param string $name
     */
    public function setClassName($name);

    /**
     * defines whether class is final or not
     * @param bool $final
     */
    public function setFinal($final);

    /**
     * set Namespace of Class
     * @param string $namespace
     */
    public function setNamespace($namespace);

    /**
     * set class to be extended
     * @param string $classname
     */
    public function setParent($classname);

    /**
     * set description for documentation
     * @param string $description
     */
    public function setDescription($description);

}
?>
