<form action="{!! $action !!}" pjax-container style="display: inline-block;">
    <div class="input-group input-group-sm hidden-xs" style="display: inline-block;">
        <input type="text" id="query" name="{{ $key }}" class="form-control" style="width: 200px;" value="{{ $value }}">

        <div class="input-group-btn" style="display: inline-block;">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> 検索</button>
        </div>
    </div>
</form>
