<?php
namespace deschdanja\ClassBuilder;

/**
 *
 * @author Theodor
 */
interface IMethod {
    /**
     * add an argument to this method
     * @param TS_ClassBuilder_IArgument $argument
     */
    public function addArgument(IArgument $argument);

    /**
     * returns name of this method, returns NULL if not set
     *
     * @return string
     */
    public function getMethodName();

    /**
     * returns string that can be used in a class
     * will throw an exception if mandatory parameters are missed (methodName)
     *
     *
     * @return string
     */
    public function getDumpString();
    
    /**
     * set whether method is abstract or not
     * @param bool $abstract
     */
    public function setAbstract($abstract);
    
    /**
     * set access level of method
     * can be "private", "protected" or "public"
     *
     * @param string $access
     */
    public function setAccess($access);

    /**
     * set description of Method, used for documentation
     * @param string $description
     */
    public function setDescription($description);

    /**
     * set executional code of method
     * basically everything between { and } in a method
     * @param string $method
     */
    public function setMethodExecutionString($method);

    /**
     * set Method Name
     * @param string $name
     */
    public function setMethodName($name);

    /**
     * set description of return Value for documentation
     * @param string $description
     */
    public function setReturnDescription($description);

    /**
     * set return type for documentation
     * @param string $type
     */
    public function setReturnType($type);

    /**
     * set whether method is static or not
     * @param bool $static
     */
    public function setStatic($static);

}
?>
