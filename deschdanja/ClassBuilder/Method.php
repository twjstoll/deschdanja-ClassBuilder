<?php
namespace deschdanja\ClassBuilder;
use deschdanja\ClassBuilder\Exceptions\InvalidArgument;

/**
 * Description of TS_ClassBuilder_Method
 *
 * @author Theodor
 */
class Method implements IMethod{
    protected $arguments = array();
    protected $abstract = false;
    protected $access = "public";
    protected $hasReturn = false;
    protected $methodExecutionString = "";
    protected $name = NULL;
    protected $description = "";
    protected $returnDescription = "";
    protected $returnType = "";
    protected $static = false;
    protected $final = false;

    /**
     * add an argument to this method
     * @param TS_ClassBuilder_IArgument $argument
     */
    public function addArgument(IArgument $argument){
        $this->arguments[]=$argument;
    }

    /**
     * returns name of this method, returns NULL if not set
     *
     * @return string
     */
    public function getMethodName(){
        return $this->name;
    }

    /**
     * returns string that can be used in a class
     * will throw an exception if mandatory parameters are missed (methodName)
     *
     *
     * @return string
     */
    public function getDumpString(){
        $arguments = array();
        $optionals = array();
        //sort into optional and non-optional arguments
        foreach($this->arguments as $argument){
            if($argument->isOptional()){
                $optionals[$argument->getName()] = $argument;
            }else{
                $arguments[$argument->getName()] = $argument;
            }
        }

        $argumentStringArray = array();
        foreach($arguments as $argument){
            $argumentStringArray[] = $argument->getDumpString();
        }
        foreach($optionals as $argument){
            $argumentStringArray[] = $argument->getDumpString();
        }

        //WRITE DOCUMENTATION PART
        $dump = "/**\n";
        $dump .= ' * '.preg_replace('/\r\n|\r|\n/', "\n * ", $this->description)."\n *\n";
        foreach($arguments as $argument){
            $dump .= " * @param ".$argument->getType(). ' $'. $argument->getName();
            $dump .= ' '.preg_replace('/\r\n|\r|\n/', "\n * ", $argument->getDescription()). "\n";
        }
        foreach($optionals as $argument){
            $dump .= " * @param ".$argument->getType(). ' $'. $argument->getName();
            $dump .= ' '.preg_replace('/\r\n|\r|\n/', "\n * ", $argument->getDescription()). "\n";
        }

        if($this->hasReturn){
            $dump .= " * \n * @return ";
            if($this->returnType != ""){
                $dump.= $this->returnType." ";
            }else{
                $dump .= "<type> ";
            }
            $dump .= preg_replace('/\r\n|\r|\n/', "\n * ", $this->returnDescription)."\n";
        }

        $dump .= " */\n";

        if($this->abstract){
            $dump.= "abstract ";
        }
        $dump .= $this->access . " ";
        if($this->static){
            $dump .= "static ";
        }
        $dump .= "function ".$this->name."(";
        $dump .= implode(", ", $argumentStringArray);
        $dump .= "){\n";
        $dump .= "    ".preg_replace('/\r\n|\r|\n/', "\n    ", $this->methodExecutionString)."\n";
        $dump .= "}";

        return $dump;
    }

    /**
     * set whether method is abstract or not
     * @param bool $abstract
     */
    public function setAbstract($abstract){
        if($abstract === true){
            $this->abstract = true;
        }else{
            $this->abstract = false;
        }
    }

    /**
     * set access level of method
     * can be "private", "protected" or "public"
     *
     * @param string $access
     */
    public function setAccess($access){
        $access = trim(strval($access));
        if($access != "public" && $access != "protected" && $access != "private"){
            throw new InvalidArgument("access has to be 'public', 'protected' or 'private'");
        }
        $this->access = $access;
    }

    /**
     * returns array with all arguments set
     * @return array filled with IArguments
     */
    public function getArguments(){
        return $this->arguments;
    }

    /**
     * set description of Method, used for documentation
     * @param string $description
     */
    public function setDescription($description){
        $this->description = trim(strval($description));
    }

    /**
     * set whether method is final
     * @param $final
     */
    public function setFinal($final){
        if($final === true){
            $this->final = true;
        }else{
            $this->final = false;
        }
    }

    /**
     * set executional code of method
     * basically everything between { and } in a method
     * @param string $method
     */
    public function setMethodExecutionString($method){
        $this->methodExecutionString = trim(strval($method));
    }

    /**
     * set Method Name
     * @param string $name
     */
    public function setMethodName($name){
        $name = trim(strval($name));
        if($name == ""){
            throw new InvalidArgument("name must not be empty");
        }
        $this->name = $name;
    }

    /**
     * set description of return Value for documentation
     * @param string $description
     */
    public function setReturnDescription($description){
        $this->returnDescription = trim(strval($description));
    }

    /**
     * set return type for documentation
     * @param string $type
     */
    public function setReturnType($type){
        $type = trim(strval($type));
        $type = preg_replace('/\r\n|\r|\n/', " ", $type);
        $this->returnType = $type;
        $this->hasReturn = true;
    }

    /**
     * set whether method is static or not
     * @param bool $static
     */
    public function setStatic($static){
        if($static === true){
            $this->static = true;
        }else{
            $this->static = false;
        }
    }
}
?>
