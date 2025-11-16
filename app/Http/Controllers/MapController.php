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
            ->select('city_id', DB::raw('COUNT(*) as total'))
            ->groupBy('city_id')
            ->orderBy('city_id')
            ->get();

        $cityLabels = $cityData->map(fn($c) => "Ciudad " . $c->city_id);
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

        // Nombre completo del asesor formateado
        $asesorData->transform(function ($a) {
            $a->full_name = trim($a->nombres . ' ' . $a->apellidos);
            return $a;
        });


        // ------------------------------------------------------
        // ENVIAR TODO A LA VISTA
        // ------------------------------------------------------
        return view('map', compact(
            'labels',
            'totals',
            'growthLabels',
            'growthTotals',
            'cityLabels',
            'cityTotals',
            'asesorData'   // 👈 nuevo dataset
        ));
    }
}
