<?php

namespace App\Http\Controllers;

use App\UrlAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UrlShortenerController extends Controller
{
    public function createShortURL(Request $request)
    {
        $request->validate([
            "url" => "required",
        ]);
        if ($request->input('expired_date') != null && $request->input('expired_date') != "") {
            $request->validate([
                "expired_date" => 'date_format:Y-m-d',
            ]);
        }
        $continue = false;
        $generatedPath = "";
        $failedCountMax = 5;
        $failedCount = 0;
        while (!$continue) {
            if ($failedCount <= $failedCountMax) {
                $random = Str::random(4);
                $urlAddress = UrlAddress::where('path_generated', $random)->first();
                if (!$urlAddress) {
                    $continue = true;
                    $generatedPath = $random;
                } else {
                    $failedCount += 1;
                }
            } else {
                $continue = true;
            }
        }
        if ($failedCount != $failedCountMax) {
            $saveGeneratedURL = new UrlAddress();
            $saveGeneratedURL['url_destination'] = $request->input('url');
            $saveGeneratedURL['path_generated'] = $generatedPath;

            if ($request->input('expired_date') != null && $request->input('expired_date') != "") {
                $saveGeneratedURL['date_expired'] = $request->input('expired_date');
            }

            if ($request->input('password') != null && $request->input('password') != "") {
                $saveGeneratedURL['password'] = Hash::make($request->input('password'));
            }

            if ($saveGeneratedURL->save()) {
                return response()->json(array(
                    "message" => "Success generate URL",
                    "url" => URL::to('/') . "/s/" . $generatedPath,
                ), 200);
            } else {
                return response()->json(array(
                    "message" => "Failed generate URL"
                ), 500);
            }
        } else {
            return response()->json(array(
                "message" => "Failed, please regenerate URL again"
            ), 500);
        }
    }

    public function openDestination(Request $request, $pathGenerated)
    {
        $urlAddress = UrlAddress::where('path_generated', $pathGenerated)->first();
        if ($urlAddress) {
            $urlAddress->click += 1;
            $urlAddress->save();

            $httpPath = "http://";
            $httpsPath = "https://";

            $hasHttpOrHttps = false;
            $url = $urlAddress->url_destination;
            if ($httpPath == substr($url, 0, strlen($httpPath))) {
                $hasHttpOrHttps = true;
            } else if ($httpsPath == substr($url, 0, strlen($httpsPath))) {
                $hasHttpOrHttps = true;
            }

            $urlExpired = false;
            if ($urlAddress['date_expired'] != null) {
                $today = Carbon::now();
                $urlExpiredDate = Carbon::parse($urlAddress['date_expired']);
                $urlExpired = $urlExpiredDate->lessThan($today);
            }

            if (!$urlExpired) {
                if ($urlAddress['password'] != null && $urlAddress['password'] != "") {
                    return view('protection', [
                        "path" => $urlAddress->path_generated,
                    ]);
                } else {
                    return Redirect::to(($hasHttpOrHttps ? "" : "http://") . $urlAddress->url_destination);
                }
            } else {
                return view('expired', [
                    "url" => URL::full(),
                ]);
            }
        } else {
            return "Wrong Path $pathGenerated";
        }
    }

    public function openProtectedDestination(Request $request, $pathGenerated)
    {
        $request->validate([
            "password" => "required",
        ]);
        $urlAddress = UrlAddress::where('path_generated', $pathGenerated)->first();
        if ($urlAddress) {
            $httpPath = "http://";
            $httpsPath = "https://";

            $hasHttpOrHttps = false;
            $url = $urlAddress->url_destination;
            if ($httpPath == substr($url, 0, strlen($httpPath))) {
                $hasHttpOrHttps = true;
            } else if ($httpsPath == substr($url, 0, strlen($httpsPath))) {
                $hasHttpOrHttps = true;
            }

            if ($urlAddress['password'] != null && $urlAddress['password'] != "") {
                if (Hash::check($request->input('password'), $urlAddress['password'])) {
                    return response()->json([
                        "message" => "Success, password match",
                        "url" => ($hasHttpOrHttps ? "" : "http://") . $urlAddress->url_destination,
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Incorrect password",
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "This path doesn't protected by password",
                ], 400);
            }
        } else {
            return response()->json([
                "message" => "Path not exist",
            ], 400);
        }
    }
}
