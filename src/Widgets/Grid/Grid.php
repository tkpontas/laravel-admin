<?php

namespace Encore\Admin\Widgets\Grid;

use Closure;
use Encore\Admin\Exception\Handler;
use Encore\Admin\Grid\Exporter;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Encore\Admin\Grid\Model;
use Encore\Admin\Grid\Row;
use Encore\Admin\Widgets\Grid\Column;
use Encore\Admin\Widgets\Grid\Concerns;
use Encore\Admin\Widgets\Grid\Displayers;
use Encore\Admin\Widgets\Grid\Tools;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Traits;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Renderable;

class Grid
{
    use Concerns\HasElementNames,
        Concerns\HasTools,
        Concerns\CanHidesColumns;

    /**
     * View for grid to render.
     *
     * @var string
     */
    protected $view = 'admin::widgets.grid.table';

    /**
     * Collection of all data rows.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $rows;

    /**
     * Collection of all grid columns.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $columns;

    /**
     * All column names of the grid.
     *
     * @var array
     */
    public $columnNames = [];

    /**
     * Per-page options.
     *
     * @var array
     */
    public $perPages = [10, 20, 30, 50, 100];

    /**
     * Default items count per-page.
     *
     * @var int
     */
    public $perPage = 20;

    /**
     * @var string
     */
    public $tableID;

    /**
     * Options for grid.
     *
     * @var array
     */
    protected $options = [
        'show_pagination'        => true,
        'show_tools'             => true,
        'show_filter'            => true,
        'show_exporter'          => true,
        'show_actions'           => true,
        'show_row_selector'      => true,
        'show_create_btn'        => true,
        'show_column_selector'   => false,
    ];

    /**
     * paginator
     *
     * @var LengthAwarePaginator
     */
    protected $paginator;

    /**
     * resourceUri(for create, edit, delete)
     *
     * @var string
     */
    protected $resourceUri;

    /**
     * Default primary key name.
     *
     * @var string
     */
    protected $keyName = 'id';

    /**
     * Grid builder.
     *
     * @var \Closure
     */
    protected $builder;

    /**
     * Callback for grid actions.
     *
     * @var Closure
     */
    protected $actionsCallback;

    /**
     * Actions column display class.
     *
     * @var string
     */
    protected $actionsClass = Displayers\Actions::class;

    /**
     * Create a new grid instance.
     *
     * @param Eloquent $model
     * @param Closure  $builder
     */
    public function __construct(Closure $builder = null)
    {
        $this->builder = $builder;

        $this->initialize();
    }

    /**
     * Initialize.
     */
    protected function initialize()
    {
        $this->tableID = uniqid('grid-table');

        $this->columns = Collection::make();
        $this->rows = Collection::make();
        
        $this->initTools();
    }

    
    /**
     * Get or set option for grid.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this|mixed
     */
    public function option($key, $value = null)
    {
        if (is_null($value)) {
            return $this->options[$key];
        }

        $this->options[$key] = $value;

        return $this;
    }

    /**
     * Get the grid paginator.
     *
     * @return mixed
     */
    public function paginator()
    {
        return new Tools\Paginator($this, $this->paginator);
    }

    /**
     * Set paginator
     *
     * @param  LengthAwarePaginator  $paginator  paginator
     *
     * @return  self
     */ 
    public function setPaginator(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;

        return $this;
    }

    /**
     * Get primary key name of model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return $this->keyName ?: 'id';
    }

    /**
     * Set primary key name of model.
     *
     * @return $this
     */
    public function setKeyName($keyName)
    {
        $this->keyName = $keyName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPerPageName()
    {
        return "per_page";
    }

    /**
     * Alias for method `disableCreateButton`.
     *
     * @return $this
     *
     * @deprecated
     */
    public function disableCreation()
    {
        return $this->disableCreateButton();
    }

    /**
     * Remove create button on grid.
     *
     * @return $this
     */
    public function disableCreateButton(bool $disable = true)
    {
        return $this->option('show_create_btn', !$disable);
    }

    /**
     * If allow creation.
     *
     * @return bool
     */
    public function showCreateBtn()
    {
        return $this->option('show_create_btn');
    }

    /**
     * Render create button for grid.
     *
     * @return string
     */
    public function renderCreateButton()
    {
        return (new Tools\CreateButton($this))->render();
    }

    /**
     * Get current resource uri.
     *
     *
     * @return string
     */
    public function resource()
    {
        return $this->getResource();
    }

    /**
     * Get resource uri.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resourceUri;
    }

    /**
     * Set resource path for grid.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setResource($path)
    {
        $this->resourceUri = $path;

        return $this;
    }

    /**
     * Set exporter driver for Grid to export.
     *
     * @param $exporter
     *
     * @return $this
     */
    public function exporter($exporter)
    {
        $this->exporter = $exporter;

        return $this;
    }

    /**
     * Get the export url.
     *
     * @param int  $scope
     * @param null $args
     *
     * @return string
     */
    public function getExportUrl($scope = 1, $args = null)
    {
        $input = array_merge(Request::all(), Exporter::formatExportQuery($scope, $args));

        return url($this->resource()).'?'.http_build_query($input);
    }

    /**
     * Get create url.
     *
     * @return string
     */
    public function getCreateUrl()
    {
        return sprintf('%s/create', $this->resource());
    }


    /**
     * Set grid action callback.
     *
     * @param Closure $actions
     *
     * @return $this
     */
    public function actions(Closure $actions)
    {
        if ($actions instanceof Closure) {
            $this->actionsCallback = $actions;
        }

        return $this;
    }

    /**
     * get rows.
     *
     * @return Collection|null
     */
    public function rows()
    {
        return $this->rows;
    }

    /**
     * Build the grid rows.
     *
     * @param array $data
     *
     * @return $this
     */
    protected function buildRows(array $data)
    {
        $this->rows = collect($data)->map(function ($model, $number) {
            return new Row($number, $model);
        });

        return $this;
    }

    /**
     * Add a column to Grid.
     *
     * @param string $name
     * @param string $label
     *
     * @return Column
     */
    public function column($name, $label = '')
    {
        if (Str::contains($name, '.')) {
            return $this->addRelationColumn($name, $label);
        }

        if (Str::contains($name, '->')) {
            return $this->addJsonColumn($name, $label);
        }

        return $this->__call($name, array_filter([$label]));
    }

    /**
     * Batch add column to grid.
     *
     * @example
     * 1.$grid->columns(['name' => 'Name', 'email' => 'Email' ...]);
     * 2.$grid->columns('name', 'email' ...)
     *
     * @param array $columns
     *
     * @return Collection|null
     */
    public function columns($columns = [])
    {
        if (func_num_args() == 0) {
            return $this->columns;
        }

        if (func_num_args() == 1 && is_array($columns)) {
            foreach ($columns as $column => $label) {
                $this->column($column, $label);
            }

            return;
        }

        foreach (func_get_args() as $column) {
            $this->column($column);
        }
    }

    /**
     * Add column to grid.
     *
     * @param string $column
     * @param string $label
     *
     * @return Column
     */
    protected function addColumn($column = '', $label = '')
    {
        $column = new Column($column, $label);
        $column->setGrid($this);

        return tap($column, function ($value) {
            $this->columns->push($value);
        });
    }

    /**
     * Prepend column to grid.
     *
     * @param string $column
     * @param string $label
     *
     * @return Column
     */
    protected function prependColumn($column = '', $label = '')
    {
        $column = new Column($column, $label);
        $column->setGrid($this);

        return tap($column, function ($value) {
            $this->columns->prepend($value);
        });
    }

    /**
     * Add `actions` column for grid.
     *
     * @return void
     */
    protected function appendActionsColumn()
    {
        if (!$this->option('show_actions')) {
            return;
        }

        $this->addColumn(Column::ACTION_COLUMN_NAME, trans('admin.action'))
            ->displayUsing($this->actionsClass, [$this->actionsCallback])
            ->escape(false);
    }

    /**
     * Disable row selector.
     *
     * @return Grid|mixed
     */
    public function disableRowSelector(bool $disable = true)
    {
        $this->tools->disableBatchActions($disable);

        return $this->option('show_row_selector', !$disable);
    }

    /**
     * Prepend checkbox column for grid.
     *
     * @return void
     */
    protected function prependRowSelectorColumn()
    {
        if (!$this->option('show_row_selector')) {
            return;
        }

        $this->prependColumn(Column::SELECT_COLUMN_NAME, ' ')
            ->displayUsing(Displayers\RowSelector::class)
            ->escape(false);
    }

    /**
     * get grid actions.
     *
     * @return string
     */
    public function getActions($row)
    {
        $class = $this->actionsClass;
        return (new $class(null, $this, null, $row))->display();
    }

    
    /**
     * Get all variables will used in grid view.
     *
     * @return array
     */
    protected function variables()
    {
        $this->variables['grid'] = $this;

        return $this->variables;
    }

    /**
     * Dynamically add columns to the grid view.
     *
     * @param $method
     * @param $arguments
     *
     * @return Column
     */
    public function __call($method, $arguments)
    {
        $label = $arguments[0] ?? null;

        return $this->addColumn($method, $label);
    }

    /**
     * Get the string contents of the grid view.
     *
     * @return string
     */
    public function render()
    {
        if ($this->builder) {
            $builder = $this->builder;
            $builder($this);
        }

        $this->prependRowSelectorColumn();
        $this->appendActionsColumn();

        $collection = collect($this->paginator->items());
        Column::setOriginalGridModels($collection);

        $this->originalCollection = $collection;
        $data = $collection->map(function($c){
            return (array)$c;
        })->toArray();

        $this->columns->map(function (Column $column) use (&$data) {
            $data = $column->fill($data);

            $this->columnNames[] = $column->getName();
        });

        $this->buildRows($data);

        return view($this->view, $this->variables())->render();
    }
}
