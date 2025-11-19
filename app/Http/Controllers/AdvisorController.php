<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Advisor;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    public function index()
    {
        $departments = DB::table('ubigeo_department')->get();
        $advisors = DB::table('advisors')
            ->join('ubigeo_department', 'ubigeo_department.id_depa', '=', 'advisors.id_depa')
            ->join('ubigeo_province', 'ubigeo_province.id_prov', '=', 'advisors.id_prov')
            ->join('ubigeo_district', 'ubigeo_district.id_dist', '=', 'advisors.id_dist')
            ->select(
                'advisors.*',
                'ubigeo_department.department as department_name',
                'ubigeo_province.province as province_name',
                'ubigeo_district.district as district_name'
            )
            ->get();

        return view('admin.advisors', compact('advisors', 'departments'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'contact'  => 'required',
            'id_depa'   => 'required',
            'id_prov' => 'required',
            'id_dist' => 'required',
        ]);

        Advisor::create($request->all());

        return redirect()->route('admin.advisors');
    }

    public function edit(Advisor $advisor)
    {
        return view('advisors.edit', compact('advisor'));
    }

    public function update(Request $request, Advisor $advisor)
    {
        $request->validate([
            'name'     => 'required',
            'contact'  => 'required',
            'id_depa'   => 'required',
            'id_prov' => 'required',
            'id_dist' => 'required',
        ]);

        $advisor->update($request->all());

        return redirect()->route('admin.advisors');
    }

    public function destroy(Advisor $advisor)
    {
        $advisor->delete();
        return redirect()->route('admin.advisors');
    }
}
