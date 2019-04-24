<?php

namespace App\Http\Controllers\Web\Member;

use App\Http\Controllers\Web\_Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends _Controller
{
    public $module = [ 'member', 'user' ];
    public $iGroupType = 999;
    public $iAcType = [ 999, 901 ];

    public $exportColumns = [
        [
            'title' => 'ID',
            'name' => 'id',
            'data' => 'users.id',
        ],
        [
            'title' => '帳號',
            'name' => 'name',
            'data' => 'users.name'
        ],
        [
            'title' => '帳號信箱',
            'name' => 'email',
            'data' => 'users.email'
        ],
        [
            'title' => '使用者性別',
            'name' => 'info.gender',
            'data' => 'users_info.gender',
            'table' => 'users_info',
            'localKey' => 'id',
            'foreignKey' => 'user_id'
        ],
        [
            'title' => '使用者連絡電話',
            'name' => 'info.contact',
            'data' => 'users_info.contact',
            'table' => 'users_info',
            'localKey' => 'id',
            'foreignKey' => 'user_id'
        ],
        [
            'title' => '使用者郵遞區號',
            'name' => 'info.zip_code',
            'data' => 'users_info.zip_code',
            'table' => 'users_info',
            'localKey' => 'id',
            'foreignKey' => 'user_id'
        ],
        [
            'title' => '使用者城市',
            'name' => 'info.city',
            'data' => 'users_info.city',
            'table' => 'users_info',
            'localKey' => 'id',
            'foreignKey' => 'user_id'
        ],
        [
            'title' => '使用者地區',
            'name' => 'info.area',
            'data' => 'users_info.area',
            'table' => 'users_info',
            'localKey' => 'id',
            'foreignKey' => 'user_id'
        ],
        [
            'title' => '使用者地址',
            'name' => 'info.address',
            'data' => 'users_info.address',
            'table' => 'users_info',
            'localKey' => 'id',
            'foreignKey' => 'user_id'
        ],
        [
            'title' => '使用者Line',
            'name' => 'info.line_id',
            'data' => 'users_info.line_id',
            'table' => 'users_info',
            'localKey' => 'id',
            'foreignKey' => 'user_id'
        ],
    ];

    /*
     *
     */
    public function index ()
    {
        return View()->make( 'web.member.user' )->with( [ 'module' => $this->module, 'exportColumns' => json_decode( json_encode( $this->exportColumns ) ) ] );
    }

    public function getList ( Request $request )
    {
        $sort_arr = [];
        $search_arr = [];
        $search_word = $request->input( 'sSearch' );
        $iDisplayLength = $request->input( 'iDisplayLength' );
        $iDisplayStart = $request->input( 'iDisplayStart' );
        $sEcho = $request->input( 'sEcho' );
        $column_arr = array_filter( explode( ',', $request->input( 'sColumns' ) ) );
        foreach ($column_arr as $key => $item) {
            if ($request->input( 'bSearchable_' . $key ) == "true") {
                $search_arr[$key] = explode( '.', $item );
            }
            if ($request->input( 'bSortable_' . $key ) == "true") {
                $sort_arr[$key] = $item;
            }
        }
        $sort_name = $sort_arr[$request->input( 'iSortCol_0' )];
        $sort_dir = $request->input( 'sSortDir_0' );

        $field_value = [];
        $field_array = [];
        $nested_sort_table = '';
        $nested_sort_local_key = '';
        $nested_sort_foreign_key = '';
        foreach ($this->exportColumns as $column) {
            if ($column) {
                $field_array[$column['name']] = $column['data'];
                if (count( explode( '.', $column['name'] ) ) > 1 && $column['name'] == $sort_name) {
                    $nested_sort_table = $column['table'] ?? '';
                    $nested_sort_local_key = $column['localKey'] ?? '';
                    $nested_sort_foreign_key = $column['foreignKey'] ?? '';
                }
                if (count( explode( '.', $column['name'] ) ) == 1) array_push( $field_value, $column['data'] . ' as ' . $column['name'] );
                if ($column['name'] == $sort_name) array_push( $field_value, $column['data'] . ' as ' . 'sorting' );
            }
        }
        // condition
        $map = [];
        // new query
        $query = User::query()->with( [ 'info' ] );
        //
        $query->where( $map );
        // search
        $query->where( function ( $query ) use ( $search_arr, $search_word, $field_array ) {
            foreach ($search_arr as $search_item) {
                $target_column = $field_array[implode( '.', $search_item )];
                $nested_column = array_pop( $search_item );
                $sub_query_model = $query->getModel();
                foreach ($search_item as $relation) {
                    if ( !is_object( $sub_query_model )) break;
                    $sub_query_model = method_exists( $sub_query_model, $relation ) ? $sub_query_model->$relation() : null;
                }
                if ($sub_query_model && $sub_query_model->getModel()->getTable() !== $query->getModel()->getTable()) {
                    $query->orWhereHas( implode( '.', $search_item ), function ( $sub_query ) use ( $nested_column, $search_word ) {
                        $sub_query->where( $nested_column, 'like', '%' . $search_word . '%' );
                    } );
                } elseif (count( $search_item ) == 0) {
                    $query->orWhere( $target_column, 'like', '%' . $search_word . '%' );
                }
            }
        } );
        // Sorting
        if ($nested_sort_table && array_has( array_pluck( $query->getQuery()->joins, 'table' ), $nested_sort_table )) $query->leftjoin( $nested_sort_table, $nested_sort_local_key, '=', $nested_sort_foreign_key );
        // Get the real count after being filtered by Where Clause
        $total_count = $query->count();
        // Execute the query
        $data_arr = $query->orderBy( 'sorting', $sort_dir )->skip( $iDisplayStart )->take( $iDisplayLength )->select( $field_value )->get();
        // Mapping the data
        foreach ($data_arr as $key => $var) {
            $var->DT_RowId = $var->id;
        }

        $this->rtndata ['status'] = 1;
        $this->rtndata ['sEcho'] = $sEcho;
        $this->rtndata ['iTotalDisplayRecords'] = $total_count;
        $this->rtndata ['iTotalRecords'] = $total_count;
        $this->rtndata ['aaData'] = $data_arr;

        return response()->json( $this->rtndata );
    }
}
