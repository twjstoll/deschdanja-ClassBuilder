<?php
namespace deschdanja\ClassBuilder;
/**
 * implementing instance encapsulated the behaviour, how to
 * convert a default Value to a string to be used in php Code
 * e.g. bool false, will be converted to string "false"
 * e.g. string "false" will be converted to string "'false'";
 * @author Theodor
 */
interface IDefaultValueHelper {
    
    /**
     * converts value to string to be used in php code
     * e.g. bool false, will be converted to string "false"
     * e.g. string "false" will be converted to string "'false'";
     * 
     * @param mixed $value cannot be resource or object
     */
    public function convertValueToString($value);
}
?>
