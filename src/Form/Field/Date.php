<?php

namespace Encore\Admin\Form\Field;

class Date extends Text
{
    /**
     * @var array<string>
     */
    protected static $css = [
        '/vendor/open-admin/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    ];

    /**
     * @var array<string>
     */
    protected static $js = [
        '/vendor/open-admin/moment/min/moment-with-locales.min.js',
        '/vendor/open-admin/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    ];

    /**
     * @var string
     */
    protected $format = 'YYYY-MM-DD';

    /**
     * @param string $format
     * @return $this
     */
    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param string $value
     * @return mixed|null
     */
    public function prepare($value)
    {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->options['format'] = $this->format;
        $this->options['locale'] = config('app.locale');
        $this->options['allowInputToggle'] = true;
        $this->options['icons'] = [
            'time' => 'fa fa-clock-o',
            'date' => 'fa fa-calendar',
            'up' => 'fa fa-chevron-up',
            'down' => 'fa fa-chevron-down',
            'previous' => 'fa fa-chevron-left',
            'next' => 'fa fa-chevron-right',
            'today' => 'fa fa-calendar-check-o',
            'clear' => 'fa fa-trash',
            'close' => 'fa fa-times'
        ];

        $this->script = "$('{$this->getElementClassSelector()}').parent().datetimepicker(".json_encode($this->options).');';

        $this->prepend('<i class="fa fa-calendar fa-fw"></i>')
            ->defaultAttribute('style', 'width: 110px !important; flex: 0 0 auto !important;')
            ->defaultAttribute('autocomplete', 'off');

        return parent::render();
    }
}
