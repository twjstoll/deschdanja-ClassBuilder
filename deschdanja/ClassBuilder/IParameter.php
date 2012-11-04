<?php
namespace deschdanja\ClassBuilder;

/**
 * class represents a parameter of a class in the class builder
 * @author Theodor
 */
interface IParameter {
    /**
     * get Name of parameter
     * @return string
     */
    public function getName();

    /**
     * returns string to be used in class
     * throws exception if mandatory parameter missing (name)
     * @return string
     */
    public function getDumpString();
    
    /**
     * set access level of parameter
     * can be "private", "protected" or "public"
     *
     * @param string $access
     */
    public function setAccess($access);

    /**
     * set name of parameter
     * @param string $name
     */
    public function setName($name);

    /**
     * set type of parameter, for documentation
     * @param string $type
     */
    public function setType($type);

    /**
     * set default value for parameter
     * can only take simple default values:
     * - null
     * - scalar values
     * - array filled with scalar values
     *
     * @param mixed $default
     */
    public function setDefault($default);

    /**
     * set description of documentation
     * @param string $description
     */
    public function setDescription($description);
}
?>
