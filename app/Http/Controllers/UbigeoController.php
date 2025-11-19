<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class UbigeoController extends Controller
{

    public function departments()
    {
        $departments = DB::table('ubigeo_department')->get();
        return response()->json($departments);
    }

    public function provinces($idDepa)
    {
        $provinces = DB::table('ubigeo_province')
             ->select('id_prov', 'province')
             ->where('id_depa', '=', $idDepa)
             ->orderBy('province', 'asc')
             ->get();
        return response()->json($provinces);
    }

    public function districts($idProv)
    {
        $districts = DB::table('ubigeo_district')
             ->select('id_dist', 'district')
             ->where('id_prov', '=', $idProv)
             ->orderBy('district', 'asc')
             ->get();
        return response()->json($districts);
    }
}
