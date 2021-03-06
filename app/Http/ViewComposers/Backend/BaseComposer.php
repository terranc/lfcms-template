<?php
/**
 * Created by PhpStorm.
 * User: terranc
 * Date: 17/7/3
 * Time: 12:55
 */

namespace App\Http\ViewComposers\Backend;


use Illuminate\View\View;

class BaseComposer
{

    /**
     * BaseComposer constructor.
     */
    public function __construct()
    {
    }

    public function compose(View $view)
    {
        $view->with('filter', 123);
    }
    protected function generate_filter(){
        foreach ($this->request->all() as $k => $v) {
            $_data = str2arr($k, 'filter_');
            if($_data && $_data[1] && (gettype($v) === 'string' && $v !== '')){
                $this->filter[$_data[1]] = $v;
            }
        }
//        $this->where = $this->filter;
        foreach ($this->filter as $k => $v) {
            // preg_match("/(start|end)_([^_]+)_(date|time|at)$/i", $k, $match);
            preg_match("/(start|end)_(.+)_(date|time|at)$/i", $k, $match);
            if(count($match) > 0){
                if($match[1] === 'start'){
                    $this->where->where($match[2] . '_' . $match[3], '>=', $v);
                }else if($match[1] === 'end'){
                    $this->where->where($match[2] . '_' . $match[3], '<', $v);
                }
            } else {
                $this->where->whereIn($k, str2arr($v));
            }
        }
        view()->share('filter', $this->filter);
    }
    protected function generate_searcher(){
        $keyword_value = request()->get('keyword_value','');
        $keyword_field = request()->get('keyword_field','');
        if(!empty($keyword_field)){
            $keyword_field = str2arr($keyword_field,'|');
            $_keyword_value = $keyword_value;
            if($_keyword_value){
                $search_query = \DB::query();
                foreach ($keyword_field as $k => $v) {
                    $_keyword_value = $keyword_value;
                    if(empty($_keyword_value)) break;
                    if(strpos($v, '.') !== false){
                        $_tmp = str2arr($v, '.');
                        $_tmp2 = str2arr($_tmp[1], '=');
                        if(count($_tmp2) > 1){
                            $foreign = str2arr(htmlspecialchars_decode($_tmp2[1]),'-');
                            $field = array($foreign[1] ?: $_tmp2[1]);
                            $_keyword_value = \DB::table(snake_case($_tmp[0]))->where($_tmp2[0], $keyword_value)->pluck($foreign[0]);
                        }else{
                            $field = array($_tmp2[0]);
                            $_keyword_value = \DB::table(snake_case($_tmp[0]))->where($_tmp[1], $keyword_value)->pluck($_tmp[1]);
                        }
                    }else{
                        $field = str2arr($v,'%');
                    }

                    if (!is_array($_keyword_value)) {
                        $_keyword_value = [$_keyword_value];
                    }
                    foreach ($_keyword_value as $oneKey) {
                        switch (count($field)) {
                            case 1:
                                $search_query->orWhere($field[0], '=', $oneKey);
                                break;
                            case 2:
                                $search_query->orWhere($field[0], 'like', $oneKey . '%');
                                break;
                            case 3:
                                $search_query->orWhere($field[0], 'like', '%' . $oneKey . '%');
                                break;
                        }
                    }
                }
                if (count($search_query)) {
                    $this->where->addNestedWhereQuery($search_query);
                }
                view()->share('keyword_value', $keyword_value);
                view()->share('keyword_field', $keyword_field);
            }
        }
    }

    /**
     *
     */
    function generate_sorter(){
        $table_sort = $this->request->get('table_sort','');
        if(!empty($table_sort)){
            list($sort_field, $sort_by) = str2arr($table_sort, '-');
            if(empty($sort_by)){
                $sort_by = 'asc'; //降序
            }
            if($sort_by == 'desc' || $sort_by == 'asc'){
                $this->setSort($sort_field . ' ' . $sort_by);
                view()->share('sort', $this->sort);
            }
        }
    }
}
