<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\MachineService;

class _Controller extends Controller
{
    protected $machine_service;

    public $view;
    public $rtndata;
    public $field;

    //CONFIGURATION for SmartAdmin UI

    //ribbon breadcrumbs config
    //array("Display Name" => "URL");
    public $breadcrumbs = array(
        "Home" => ""
    );

    /*navigation array config

    ex:
    "dashboard" => array(
        "title" => "Display Title",
        "url" => "http://yoururl.com",
        "url_target" => "_self",
        "icon" => "fa-home",
        "label_htm" => "<span>Add your custom label/badge html here</span>",
        "sub" => array() //contains array of sub items with the same format as the parent
    )

    */
    public $page_nav = array(
        "blank" => array(
            "title" => "Blank",
            "icon" => "fa-home",
            "url" => "ajax/dashboard.php"
        )
    );

    //configuration variables
    public $page_title = "";
    public $page_css = array();
    public $no_main_header = false; //set true for lock.php and login.php
    public $page_body_prop = array(); //optional properties for <body>
    public $page_html_prop = array(); //optional properties for <html>

    public function __construct ()
    {
        $this->machine_service = new MachineService();
        View()->share('_machine_service', $this->machine_service);
        View()->share('_memory_usage', $this->machine_service->getServerMemoryUsage(true));

        View()->share('breadcrumbs', $this->breadcrumbs);
        View()->share('page_nav', $this->page_nav);
        View()->share('page_title', $this->page_title);
        View()->share('page_css', $this->page_css);
        View()->share('no_main_header', $this->no_main_header);
        View()->share('page_body_prop', $this->page_body_prop);
        View()->share('page_html_prop', $this->page_html_prop);

        $this->__init_field();
        View()->share( 'field', json_decode( json_encode( $this->field ) ) );
    }

    public function __init_field ()
    {
        $this->field = [
            'get' => [

            ],
            'add' => [

            ],
            'edit' => [

            ]
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder mixed
     */
    public function __init_datatable_query ( $query )
    {
        $this->__init_field();
        $sort_arr = [];
        $search_arr = [];
        $search_word = request()->input( 'sSearch' );
        $column_arr = array_filter( explode( ',', request()->input( 'sColumns' ) ) );
        foreach ($column_arr as $key => $item) {
            if (request()->input( 'bSearchable_' . $key ) == "true") {
                $search_arr[$key] = explode( '.', $item );
            }
            if (request()->input( 'bSortable_' . $key ) == "true") {
                $sort_arr[$key] = $item;
            }
        }
        $sort_name = $sort_arr[request()->input( 'iSortCol_0' )];
        $sort_dir = request()->input( 'sSortDir_0' );
        $field_value = [];
        $field_array = [];
        $nested_sort_table = '';
        $nested_sort_local_key = '';
        $nested_sort_foreign_key = '';
        foreach ($this->field['get'] as $column) {
            if (key_exists( 'name', $column ) && key_exists( 'data', $column )) {
                $field_array[$column['name']] = $column['data'];
                if (count( explode( '.', $column['name'] ) ) > 1 && $column['name'] == $sort_name) {
                    $nested_sort_table = $column['table'] ?? '';
                    $nested_sort_local_key = $column['localKey'] ?? '';
                    $nested_sort_foreign_key = $column['foreignKey'] ?? '';
                }
                if (count( explode( '.', $column['name'] ) ) == 1) array_push( $field_value, $column['data'] . ' as ' . $column['name'] );
                if ($column['name'] == $sort_name) {
                    //array_push( $field_value, $column['data'] . ' as ' . 'sorting' );
                    $sort_name = $column['data'];
                }
            }
        }
        // search
        $query->where( function ( \Illuminate\Database\Eloquent\Builder $query ) use ( $search_arr, $search_word, $field_array ) {
            foreach ($search_arr as $search_item) {
                $target_column = $field_array[implode( '.', $search_item )];
                $nested_column = array_pop( $search_item );
                $sub_query_model = $query->getModel();
                foreach ($search_item as $relationKey => $relation) {
                    if ( !is_object( $sub_query_model )) break;
                    if(method_exists( $sub_query_model, $relation ) && ($relationKey == count($search_item)-1)){
                        $sub_query_model = $sub_query_model->$relation();
                    }
                    else if(method_exists( $sub_query_model, $relation )){
                        $sub_query_model = $sub_query_model->$relation()->getModel();
                    }
                    else{
                        $sub_query_model = null;
                    }
                }
                if ($sub_query_model && $sub_query_model->getModel()->getTable() !== $query->getModel()->getTable()) {
                    $query->orWhereHas( implode( '.', $search_item ), function ( \Illuminate\Database\Eloquent\Builder $sub_query ) use ( $nested_column, $search_word ) {
                        $sub_query->where( $nested_column, 'like', '%' . $search_word . '%' );
                    } );
                } elseif (count( $search_item ) == 0) {
                    $query->orWhere( $target_column, 'like', '%' . $search_word . '%' );
                }
            }
        } );
        // Sorting
        if ($nested_sort_table && !array_has( array_pluck( $query->getQuery()->joins ?? [], 'table' ), $nested_sort_table )) {
            $query->leftjoin( $nested_sort_table, $query->getModel()->getTable() . '.' . $nested_sort_local_key, '=', $nested_sort_table . '.' . $nested_sort_foreign_key );
        }
        //
        //return $query->select( $field_value )->orderBy( 'sorting', $sort_dir );
        return $query->select( $field_value )->orderBy( $sort_name, $sort_dir );
    }
}
