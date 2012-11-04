<?php
namespace deschdanja\ClassBuilder;
use deschdanja\ClassBuilder\Exceptions\InvalidArgument;

/**
 * Description of TS_ClassBuilder_Argument
 *
 * @author Theodor
 */
class Argument implements IArgument{
    protected $name = NULL;
    protected $type = NULL;
    protected $isOptional = false;
    protected $passedByReference = false;
    protected $defaultValue = NULL;
    protected $description= "";

    /**
     *
     * @var TS_ClassBuilder_IDefaultValueHelper
     */
    protected $defaultValueHelper;

    /**
     *
     * @param TS_ClassBuilder_IDefaultValueHelper $helper
     */
    public function __construct(IDefaultValueHelper $helper) {
        $this->defaultValueHelper = $helper;
    }
    
    /**
     * returns string to be used in method or class as argument
     * throws exception if mandatory parameter missing (name)
     * @return string
     */
    public function getDumpString(){
        if($this->name == ""){
            throw new InvalidArgument("name must not be empty");
        }

        $dump = "";

        //typehinting
        if(!is_null($this->type)){
            $dump = $dump . $this->type . " ";
        }

        //passed by reference
        if($this->passedByReference){
            $dump .= "&";
        }

        //argument name
        $dump = $dump . '$' .$this->name;

        //default value
        if($this->isOptional){
            $dump = $dump . " = ";
            $dump.= $this->defaultValueHelper->convertValueToString($this->defaultValue);
        }

        return $dump;
    }

    /**
     * returns name of argument
     * @return $string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * returns description of argument
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * returns type for typehint in doc
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * Set Name of Argument
     * @param string $name
     */
    public function setName($name){
        $name = trim(strval($name));
        if($name == ""){
            throw new InvalidArgument("name cannot be empty string");
        }
        $this->name = $name;
    }

    /**
     * set type for typeHinting of Argument
     * @param string $type
     */
    public function setType($type){
        $this->type = strval($type);
    }

    /**
     * setDefault Value (makes argument optional)
     * cannot be object, resource
     * @param mixed $default
     */
    public function setDefaultValue($default){
        if(is_object($default) || is_resource($default)){
            throw new InvalidArgument("default value cannot be object or resource");
        }
        $this->defaultValue = $default;
        $this->isOptional = true;
    }

    /**
     * set Description of Argument for Documentation
     * @param string $description
     */
    public function setDescription($description){
        $this->description = strval($description);
    }

    /**
     * set, whether argument is passed by reference
     * @param bool $bool
     */
    public function setPassedByReference($bool){
        if($bool === true){
            $this->passedByReference = true;
        }else{
            $this->passedByReference = false;
        }
    }

    /**
     * returns whether this argument is optional
     *
     * @return bool
     */
    public function isOptional(){
        return $this->isOptional;
    }
}
?>
