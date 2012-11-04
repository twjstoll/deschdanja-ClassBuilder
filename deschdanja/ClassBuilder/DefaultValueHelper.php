<?php
namespace deschdanja\ClassBuilder;
use deschdanja\ClassBuilder\Exceptions\InvalidArgument;
use deschdanja\ClassBuilder\Exceptions\OperationNotAllowed;
use deschdanja\ClassBuilder\Exceptions\OperationUnsupported;

/**
 * Description of TS_ClassBuilder_DefaultValueHelper
 *
 * @author Theodor
 */
class DefaultValueHelper implements IDefaultValueHelper {
    /**
     * maxdepht
     */
    const maxdepth = 5;
    protected $depth = 0;

    /**
     * converts value to string to be used in php code
     * e.g. bool false, will be converted to string "false"
     * e.g. string "false" will be converted to string "'false'";
     *
     * @param mixed $value cannot be resource or object
     */
    public function convertValueToString($value) {
        if(is_resource($value) || is_object($value)){
            throw new InvalidArgument("cannot convert resources or objects");
        }

        if(is_array($value)){
            $this->depth++;
            //$depth = $this->depth;
            if($this->depth > self::maxdepth){
                throw new OperationNotAllowed("maxdepth of array in array reached");
            }
            $string = "array(";
            if(count($value)>0){
                foreach($value as $key => $val){
                    $val = $this->convertValueToString($val);
                    //$this->depth = $depth;
                    if(!is_numeric($key)){
                        $key = "'".$key."'";
                    }
                    $string .= $key . " => " . $val.", ";
                }
                $string = substr($string, 0, -2);
            }
            $string .=")";

            $this->depth--;

            return $string;
        }

        if (!is_scalar($value) && !is_null($value)) {
            throw new InvalidArgument("value has to be array, scalar or null");
        }
        if (is_string($value)) {
            return "'$value'";
        }
        if (is_numeric($value)) {
            return strval($value);
        }
        if ($value === true) {
            return "true";
        }
        if ($value === false) {
            return "false";
        }
        if (is_null($value)) {
            return "NULL";
        }
        throw new OperationUnsupported("cannot convert value to desired string");
    }

}

?>
