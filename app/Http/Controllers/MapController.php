<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index()
    {
        // ------------------------------------------------------
        // 1) DATOS PARA EL PIE CHART (Service Types)
        // ------------------------------------------------------
        $serviceData = DB::table('reports')
            ->join('service_types', 'reports.service_id', '=', 'service_types.id')
            ->select('service_types.name as label', DB::raw('COUNT(*) as total'))
            ->groupBy('service_types.name')
            ->orderBy('label')
            ->get();

        $labels = $serviceData->pluck('label');
        $totals = $serviceData->pluck('total');


        // ------------------------------------------------------
        // 2) DATOS PARA EL LINE CHART (Crecimiento Mensual)
        // ------------------------------------------------------
        $monthlyGrowth = DB::table('reports')
            ->select(
                DB::raw("YEAR(date) as year"),
                DB::raw("MONTH(date) as month"),
                DB::raw("COUNT(*) as total")
            )
            ->where('service_id', 1)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $growthLabels = $monthlyGrowth->map(function ($m) {
            return \Carbon\Carbon::create($m->year, $m->month)->locale('es')->isoFormat('MMM YYYY');
        });

        $growthTotals = $monthlyGrowth->pluck('total');


        // ------------------------------------------------------
        // 3) DATOS PARA EL BAR CHART (City)
        // ------------------------------------------------------
        $cityData = DB::table('reports')
            ->select(
                'reports.city_id',
                'p.province as city_name',
                'd.department as department_name',
                DB::raw('COUNT(*) as total')
            )
            ->join('ubigeo_province as p', 'p.id_prov', '=', 'reports.city_id')
            ->join('ubigeo_department as d', 'd.id_depa', '=', 'p.id_depa')
            ->groupBy(
                'reports.city_id',
                'p.province',
                'd.department'
            )
            ->orderBy('reports.city_id')
            ->get();



        $cityLabels = $cityData->map(function ($c) {
            return "{$c->city_name} - {$c->department_name}";
        });
        $cityTotals = $cityData->pluck('total');


        // ------------------------------------------------------
        // 4) RESUMEN NACIONAL (Asesores)
        // ------------------------------------------------------
        $asesorData = DB::table('reports')
            ->join('users', 'reports.asesor_id', '=', 'users.id')
            ->select(
                'users.nombres',
                'users.apellidos',
                'reports.asesor_id',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('reports.asesor_id', 'users.nombres', 'users.apellidos')
            ->orderBy('total', 'desc')
            ->get();

        // Nombre completo del asesor
        $asesorData->transform(function ($a) {
            $a->full_name = trim($a->nombres . ' ' . $a->apellidos);
            return $a;
        });


        // ------------------------------------------------------
        // 5) NUEVO: SUMATORIA POR CITY Y SERVICE_ID (para openModal)
        // ------------------------------------------------------
        // ------------------------------------------------------
        // 5) PREPARAR cityServiceSummary (asociativo por city_id)
        // ------------------------------------------------------
        $cityServices = DB::table('reports')
            ->select(
                'city_id',
                DB::raw("SUM(CASE WHEN service_id = 1 THEN 1 ELSE 0 END) AS formalizacion"),
                DB::raw("SUM(CASE WHEN service_id = 2 THEN 1 ELSE 0 END) AS asesorias"),
                DB::raw("SUM(CASE WHEN service_id = 3 THEN 1 ELSE 0 END) AS eventos"),
                DB::raw("SUM(CASE WHEN service_id = 4 THEN 1 ELSE 0 END) AS consultas_asesor")
            )
            ->groupBy('city_id')
            ->orderBy('city_id')
            ->get();

        // Convertir a array asociativo indexado por city_id para JS
        $cityServiceSummary = $cityServices
            ->mapWithKeys(function ($item) {
                return [
                    (int)$item->city_id => [
                        'city_id' => (int)$item->city_id,
                        'formalizacion' => (int)$item->formalizacion,
                        'asesorias' => (int)$item->asesorias,
                        'eventos' => (int)$item->eventos,
                        'consultas' => (int)$item->consultas_asesor,
                    ]
                ];
            })->toArray();



        // ------------------------------------------------------
        // ENVIAR TODO A LA VISTA
        // ------------------------------------------------------
        return view('admin.map', compact(
            'labels',
            'totals',
            'growthLabels',
            'growthTotals',
            'cityLabels',
            'cityTotals',
            'asesorData',
            'cityServices',
            'cityServiceSummary' // <-- agregar aquí
        ));
    }
}
