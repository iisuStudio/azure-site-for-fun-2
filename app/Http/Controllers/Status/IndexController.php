<?php

namespace App\Http\Controllers\Status;

use App\Models\TrackerLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use PragmaRX\Tracker\Support\Minutes;

class IndexController extends _Controller
{
    function index ()
    {
        return View()->make( 'status.index' )->with([
            'page_view' => $this->pageViews( 60 * 24 * 7),
            'page_view_country' => $this->tracker->pageViewsByCountry( 60 * 24 * 30)->each(function($item){
                $item->color = '#' . str_pad(dechex(mt_rand(30, 225)), 2, '0', STR_PAD_LEFT)
                    . str_pad(dechex(mt_rand(30, 225)), 2, '0', STR_PAD_LEFT)
                    . str_pad(dechex(mt_rand(30, 225)), 2, '0', STR_PAD_LEFT);
            })
        ]);
    }

    function visits ()
    {
        return View()->make( 'status.visits' )->with(['field'=>$this->tracker->sessions(60 * 24)]);
    }

    function errors ()
    {
        $logs = $this->tracker->errors( 60 * 24 * 7 );

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;

        $logs = array_reverse(array_sort($logs , function ($value) {
            return $value['created_at'];
        }));
        $currentItems = array_slice($logs, $perPage * ($currentPage - 1), $perPage);

        $logs = new LengthAwarePaginator($currentItems, count($logs), $perPage, $currentPage, [
            'path' => url('status/errors')
        ]);

        return View()->make( 'status.errors' )->with([
            'logs' => $logs
        ]);
    }

    public function pageViews($minutes)
    {
        $query = TrackerLog::query()->select(
            DB::raw('FORMAT(created_at, \'yyyy-MM-dd\') as date, count(*) as total')
        )->groupBy(
            DB::raw('FORMAT(created_at, \'yyyy-MM-dd\')')
        )
            ->period(Minutes::make($minutes))
            ->orderBy('date');

        return $query->get();
    }
}