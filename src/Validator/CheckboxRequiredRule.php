<?php
namespace Encore\Admin\Validator;

use Illuminate\Contracts\Validation\Rule;

/**
 * CheckboxRequiredRule
 */
class CheckboxRequiredRule implements Rule
{
    /**
    * Check Validation
    *
    * @param  string  $attribute
    * @param  mixed  $value
    * @return bool
    */
    public function passes($attribute, $value)
    {
        if(is_null($value)){
            return false;
        }
        if(!is_array($value)){
            $value = [$value];
        }
        $value = array_filter($value, 'strlen');

        return count($value) > 0;
    }
    
    /**
     * get validation error message
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.required');
    }
}
