<?php

namespace Encore\Admin\Traits;

use Illuminate\Support\Arr;

trait FormTrait
{
    /**
     * unique class name for class selector
     * 
     * @var string
     */
    protected $uniqueName;

    /**
     * If the form horizontal layout.
     *
     * @var bool
     */
    protected $horizontal = true;

    
    /**
     * Set unique class name for class selector
     *
     * @return  $this
     */ 
    public function setUniqueName($uniqueName)
    {
        $this->uniqueName = $uniqueName;
        return $this;
    }

    /**
     * Get unique class name for class selector
     *
     * @return  string
     */ 
    public function getUniqueName()
    {
        if(!$this->uniqueName){
            $this->uniqueName = 'form-' . mb_substr(md5(uniqid()), 0, 32);
        }
        return $this->uniqueName;
    }

    /**
     * @return bool
     */
    public function getHorizontal()
    {
        return $this->horizontal;
    }

    /**
     * @return $this
     */
    public function setHorizontal(bool $horizontal)
    {
        $this->horizontal = $horizontal;
        
        return $this; 
    }

    /**
     * @return $this
     */
    public function disableHorizontal()
    {
        $this->horizontal = false;

        return $this;
    }

    /**
     * set class
     *
     * @param string|array $value
     * @return $this
     */
    public function setClass($value)
    {
        $result = explode(' ', Arr::get($this->attributes, 'class'));

        if(is_string($value)){
            $value = explode(' ', $value);
        }
        foreach($value as $v){
            if(empty($v)){
                continue;
            }
            $result[] = $v;
        }

        $result = implode(' ', array_unique($result));
        $this->attributes['class'] = $result;
    }
}
