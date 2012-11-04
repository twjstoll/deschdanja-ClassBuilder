<?php

namespace deschdanja\ClassBuilder;

use deschdanja\ClassBuilder\Exceptions\InvalidArgument;
use deschdanja\ClassBuilder\Exceptions\OperationUnsupported;
use deschdanja\ClassBuilder\Exceptions\OperationNotAllowed;
use deschdanja\ClassBuilder\Exceptions\ClassBuilderException;

/**
 * Description of ClassBuilder
 *
 * @author Theodor
 */
class ClassBuilder implements IClassBuilder {

    protected $abstract = false;
    protected $description = "";
    protected $final = false;
    protected $interfaces = array();
    protected $methods = array();
    protected $name = NULL;
    protected $namespace = NULL;
    protected $parameters = array();
    protected $parent = "";

    /**
     * add interface that is implemented by Class
     * empty methods basing on interface will be added automatically if they don't exist
     * @param string $interface
     */
    public function addInterface($interface) {
        $interface = \trim(\strval($interface));
        $this->interfaces[$interface] = $interface;
    }

    /**
     * add method to class
     * @param TS_ClassBuilder_IMethod $method
     */
    public function addMethod(IMethod $method) {
        $this->methods[] = $method;
    }

    /**
     * add parameter to this class
     * @param TS_ClassBuilder_IParameter $parameter
     */
    public function addParameter(IParameter $parameter) {
        $this->parameters[] = $parameter;
    }

    /**
     * passes dumpString to eval to declare class
     */
    public function declareClass() {
        $fullClassName = $this->getClassName(true);
        if (\class_exists($fullClassName, false)) {
            throw new OperationNotAllowed("Class '$fullClassName' is already declared, cannot redeclare");
        }
        
        if (eval($this->getDumpString()) === false) {
            throw new ClassBuilderException("Could not declare Class!");
        }
        return;
    }

    /**
     * returns class name, either full or short
     * @param bool $full indicates, whether to return full classname
     * @return string
     */
    public function getClassName($full = true) {
        $name = "";
        if ($full === true) {
            $name.="\\" . $this->namespace . "\\";
        }
        $name.=$this->name;
        return $name;
    }

    /**
     * returns string that can be used to declare class
     * @return string
     */
    public function getDumpString() {
        if (\is_null($this->name)) {
            throw new OperationUnsupported("name of class is not set, cannot create class dump string");
        }

        //get and sort parameters
        $parameters = array();
        foreach ($this->parameters as $parameter) {
            $parameters[$parameter->getName()] = $parameter;
        }
        \ksort($parameters);

        //get and sort methods
        $methods = array();
        foreach ($this->methods as $method) {
            $methods[$method->getMethodName()] = $method;
        }
        \ksort($methods);

        $dump = "";
        //NAMESPACE
        if ($this->namespace != "") {
            $dump .= 'namespace ' . $this->namespace . ";\n\n";
        }
        //DOC
        $dump .= "/**\n * This Class was created with the use of " . __CLASS__ . "\n";
        $dump .= " * " . preg_replace('/\r\n|\r|\n/', "\n * ", $this->description) . "\n";
        $dump .= " */\n";

        //class
        if ($this->final) {
            $dump.= "final ";
        }
        if ($this->abstract) {
            $dump.= "abstract ";
        }
        $dump .= "class " . $this->name . " ";
        if ($this->parent != "") {
            $dump .= "extends " . $this->parent . " ";
        }
        if ($this->interfaces !== array()) {
            $dump.= "implements " . \implode(", ", $this->interfaces) . " ";
        }
        $dump.="{\n";

        $tab = "    ";
        //write parameters
        foreach ($parameters as $parameter) {
            $dump.="\n$tab" . preg_replace('/\r\n|\r|\n/', "\n$tab", $parameter->getDumpString()) . "\n";
        }
        $dump.="\n";

        //write methods
        foreach ($methods as $method) {
            $dump.="\n$tab" . preg_replace('/\r\n|\r|\n/', "\n$tab", $method->getDumpString()) . "\n";
        }

        //end class
        $dump.="\n}";

        return $dump;
    }

    /**
     * set whether class abstract or not
     * @param bool $abstract
     */
    public function setAbstract($abstract) {
        if ($abstract === true) {
            $this->abstract = true;
        } else {
            $this->abstract = false;
        }
    }

    /**
     * set name of class
     * @param string $name
     */
    public function setClassName($name) {
        $name = \trim(\strval($name));
        if ($name == "") {
            throw new InvalidArgument("name must not be empty");
        }
        $this->name = $name;
    }

    /**
     * defines whether class is final or not
     * @param bool $final
     */
    public function setFinal($final) {
        if ($final === true) {
            $this->final = true;
        } else {
            $this->final = false;
        }
    }

    /**
     * set Namespace of Class
     * @param string $namespace
     */
    public function setNamespace($namespace) {
        $this->namespace = \trim(\strval($namespace));
    }

    /**
     * set class to be extended
     * @param string $classname
     */
    public function setParent($classname) {
        $this->parent = \trim(\strval($classname));
    }

    /**
     * set description for documentation
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = \trim(\strval($description));
    }

}

?>
