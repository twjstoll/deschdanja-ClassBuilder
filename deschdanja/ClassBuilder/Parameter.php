<?php
namespace deschdanja\ClassBuilder;
use deschdanja\ClassBuilder\Exceptions\OperationUnsupported;
use deschdanja\ClassBuilder\Exceptions\InvalidArgument;

/**
 * Description of TS_ClassBuilder_Parameter
 *
 * @author Theodor
 */
class Parameter implements IParameter{
    protected $access = "public";
    protected $name = NULL;
    protected $type = "";

    protected $hasDefault = false;
    protected $defaultValue = NULL;

    protected $static = false;
    
    protected $description = "";

    /**
     *
     * @var TS_ClassBuilder_IDefaultValueHelper
     */
    protected $defaultValueHelper;

    public function __construct(IDefaultValueHelper $helper) {
        $this->defaultValueHelper = $helper;
    }

    /**
     * get Name of parameter
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * returns string to be used in class
     * throws exception if mandatory parameter missing (name)
     * @return string
     */
    public function getDumpString(){
        if(!is_string($this->name)){
            throw new OperationUnsupported("name is not set, therefore no dump string can be returned");
        }
        $dump = "/** \n * ";
        //replace every new line with *\n
        $dump .= preg_replace('/\r\n|\r|\n/', "\n * ", $this->description)."\n * ";
        $dump .= "@var ".$this->type.' $'.$this->name;
        $dump .= "\n */\n";
        $dump .= $this->access;
        if($this->static){
            $dump .= " static";
        }
        $dump.= ' $'. $this->name;
        if($this->hasDefault){
            $dump .= " = ";
            $dump .= $this->defaultValueHelper->convertValueToString($this->defaultValue);
        }
        $dump .= ";";
        return $dump;
    }

    /**
     * set access level of parameter
     * can be "private", "protected" or "public"
     *
     * @param string $access
     */
    public function setAccess($access){
        $access = trim(strval($access));
        if($access != "private" && $access != "protected" && $access != "public"){
            throw new InvalidArgument("access has to be 'private', 'protected' or 'public'");
        }
        $this->access = $access;
    }

    /**
     * set name of parameter
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
     * set type of parameter, for documentation
     * @param string $type
     */
    public function setType($type){
        $this->type = trim(strval($type));
    }

    /**
     * set default value for parameter
     * can only take simple default values:
     * - null
     * - scalar values
     * - array filled with these values
     *
     * @param mixed $default
     */
    public function setDefault($default){
        if(is_scalar($default) || is_null($default) || is_array($default)){
            //these values can be set directly
        }else{
            throw new InvalidArgument("default value can only be scalar, null or array");
        }
        $this->defaultValue = $default;
        $this->hasDefault = true;
    }

    /**
     * set description of documentation
     * @param string $description
     */
    public function setDescription($description){
        $this->description = trim(strval($description));
    }
    
    public function setStatic($static) {
        if($static === true){
            $this->static = true;
        }else{
            $this->static = false;
        }
    }

}
?>
