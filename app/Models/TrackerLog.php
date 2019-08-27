<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerLog extends Model
{
    //
    protected $table = 'tracker_log';
    protected $primaryKey = 'tracker_log_id';

    public function scopePeriod($query, $minutes, $alias = '')
    {
        $alias = $alias ? "$alias." : '';

        return $query
            ->where($alias.'updated_at', '>=', $minutes->getStart() ? $minutes->getStart() : 1)
            ->where($alias.'updated_at', '<=', $minutes->getEnd() ? $minutes->getEnd() : 1);
    }
}
