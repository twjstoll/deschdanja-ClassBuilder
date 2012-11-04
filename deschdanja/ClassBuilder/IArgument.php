<?php
namespace deschdanja\ClassBuilder;

/**
 *
 * @author Theodor
 */
interface IArgument {
    /**
     * returns string to be used in method or class as argument
     * throws exception if mandatory parameter missing (name)
     * @return string
     */
    public function getDumpString();
    
    /**
     * returns name of argument
     * @return string
     */
    public function getName();

    /**
     * returns description of argument
     * @return string
     */
    public function getDescription();

    /**
     * returns type for typehint in doc
     * @return string
     */
    public function getType();

    /**
     * Set Name of Argument
     * @param string $name
     */
    public function setName($name);

    /**
     * set type for typeHinting of Argument
     * @param string $type
     */
    public function setType($type);

    /**
     * setDefault Value (makes argument optional)
     * @param mixed $default
     */
    public function setDefaultValue($default);

    /**
     * set Description of Argument for Documentation
     * @param string $description
     */
    public function setDescription($description);

    /**
     * set, whether argument is passed by reference
     * @param bool $bool
     */
    public function setPassedByReference($bool);

    /**
     * returns whether this argument is optional
     *
     * @return bool
     */
    public function isOptional();


}
?>
