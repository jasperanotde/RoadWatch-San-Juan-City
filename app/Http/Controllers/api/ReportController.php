<?php

namespace App\Http\Controllers\api;


use App\Models\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Report as ReportResource;

class ReportController extends Controller
{
    /**
     * Get outlet listing on Leaflet JS geoJSON data structure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $reports = Report::all();

        $geoJSONdata = $reports->map(function ($report) {
            return [
                'type'       => 'Feature',
                'properties' => new ReportResource($report),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $report->longitude,
                        $report->latitude,
                    ],
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }
}
