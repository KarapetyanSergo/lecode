<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class VisitController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $ip = $request->ip();
            $loaction = Location::get($ip);
    
            return response()->json($this->successResponse(Visit::create([
                'ip' => $ip,
                'country' => $loaction->countryName,
                'city' => $loaction->cityName
            ])));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()), 400);
        }
    }

    public function getStatisticsByHour(): JsonResponse
    {
        try {
            $visits = DB::query()
            ->selectRaw('hour, COUNT(*) AS visits_count')
            ->fromSub(function ($query) {
                $query->selectRaw('HOUR(created_at) AS hour, ip')
                ->from('visits')
                ->groupBy('ip', 'hour');
            }, 'unique_visits')
            ->groupBy('hour')
            ->get();

            return response()->json($this->successResponse($visits));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()), 400);
        }
    }

    public function getStatisticsByLocation(): JsonResponse
    {
        try {
            $visits = DB::query()
            ->select('country', 'city')
            ->selectRaw('COUNT(*) as visits_count')
            ->fromSub(function ($query) {
                $query->select('country', 'city', 'ip')
                ->from('visits')
                ->groupBy('country', 'city', 'ip');
            }, 'unique_visits')
            ->groupBy('country', 'city')
            ->get();

            return response()->json($this->successResponse($visits));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()), 400);
        }
    }
}
