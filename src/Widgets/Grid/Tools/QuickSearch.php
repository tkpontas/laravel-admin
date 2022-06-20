<?php

namespace Encore\Admin\Widgets\Grid\Tools;

use Encore\Admin\Grid\Concerns\HasQuickSearch;
use Illuminate\Support\Arr;

class QuickSearch extends AbstractTool
{
    /**
     * @var string
     */
    protected $view = 'admin::grid.quick-search';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $query = request()->query();

        Arr::forget($query, HasQuickSearch::getSearchKey());

        $vars = [
            'action' => request()->url().'?'.http_build_query($query),
            'key'    => HasQuickSearch::getSearchKey(),
            'value'  => request(HasQuickSearch::getSearchKey()),
        ];

        return view($this->view, $vars);
    }
}
