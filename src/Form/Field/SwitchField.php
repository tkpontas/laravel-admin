<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;
use Encore\Admin\Validator\HasOptionRule;
use Illuminate\Support\Arr;

class SwitchField extends Field
{
    protected static $css = [
        '/vendor/laravel-admin/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
    ];

    protected static $js = [
        '/vendor/laravel-admin/bootstrap-switch/dist/js/bootstrap-switch.min.js',
    ];

    protected $states = [
        'on'  => ['value' => 1, 'text' => 'ON', 'color' => 'primary'],
        'off' => ['value' => 0, 'text' => 'OFF', 'color' => 'default'],
    ];

    protected $size = 'small';

    /**
     * Field constructor.
     *
     * @param       $column
     * @param array $arguments
     */
    public function __construct($column = '', $arguments = [])
    {
        parent::__construct($column, $arguments);

        $this->rules([new HasOptionRule($this)]);
    }
    
    public function getOptions(){
        return collect($this->states)->mapWithKeys(function($state){
            return [Arr::get($state, 'value') => Arr::get($state, 'text')];
        })->toArray();
    }

    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    public function states($states = [])
    {
        foreach (Arr::dot($states) as $key => $state) {
            Arr::set($this->states, $key, $state);
        }

        return $this;
    }

    public function prepare($value)
    {
        if (isset($this->states[$value])) {
            return $this->states[$value]['value'];
        }

        return $value;
    }

    public function render()
    {
        if(is_null($this->value())){
            $this->value = $this->states['off']['value'];
        }else{
            foreach ($this->states as $state => $option) {
                if ($this->value() == $option['value']) {
                    $this->value = $state;
                    break;
                }
            }
        }

        $this->script = <<<EOT

$('{$this->getElementClassSelector()}.la_checkbox').bootstrapSwitch({
    size:'{$this->size}',
    onText: '{$this->states['on']['text']}',
    offText: '{$this->states['off']['text']}',
    onColor: '{$this->states['on']['color']}',
    offColor: '{$this->states['off']['color']}',
    onSwitchChange: function(event, state) {
        $(event.target).closest('.bootstrap-switch').next().val(state ? 'on' : 'off').change();
    }
});

EOT;

        return parent::render();
    }
}
