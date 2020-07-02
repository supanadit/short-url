<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UrlAddress extends Model
{
    protected $appends = [
        'is_expired',
        'full_url_destination'
    ];

    public function getFullUrlDestinationAttribute()
    {
        $httpPath = "http://";
        $httpsPath = "https://";

        $hasHttpOrHttps = false;
        $url = $this['url_destination'];
        if ($httpPath == substr($url, 0, strlen($httpPath))) {
            $hasHttpOrHttps = true;
        } else if ($httpsPath == substr($url, 0, strlen($httpsPath))) {
            $hasHttpOrHttps = true;
        }
        return ($hasHttpOrHttps ? "" : "http://") . $this['url_destination'];
    }

    public function getIsExpiredAttribute()
    {
        $urlExpired = false;
        if ($this['date_expired'] != null) {
            $today = Carbon::now()->setTime(0, 0, 0);
            $urlExpiredDate = Carbon::parse($this['date_expired']);
            if (!$today->equalTo($urlExpiredDate)) {
                $urlExpired = $urlExpiredDate->lessThanOrEqualTo($today);
            }
        }
        return $urlExpired;
    }
}
