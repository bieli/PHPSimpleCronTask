<?php

class PropertiesManager extends SimpleFileLogger
{
    const ERR_MSG_PATTERN = '%s: Not exists property "%s" in object "%s"';

    protected $className  = '';
    protected $properties = array();

    public function __construct($i_ClassName = __CLASS__)
    {
        $this->className  = $i_ClassName;
        $this->properties = get_class_vars($this->className);
    }

    public function __get($i_PropertyName)
    {
        if ( array_key_exists($i_PropertyName, $this->properties) )
        {
            return $this->$i_PropertyName;
        }
        else
        {
            throw new Exception(sprintf(self::ERR_MSG_PATTERN,
                                '__get()', $i_PropertyName, $this->className));
        }
    }

    public function __set($i_PropertyName, $i_Value)
    {
        if ( array_key_exists($i_PropertyName, $this->properties) )
        {
            $this->$i_PropertyName = $i_Value;
        }
        else
        {
            throw new Exception(sprintf(self::ERR_MSG_PATTERN,
                                '__set()', $i_PropertyName, $this->className));
        }
    }
}

