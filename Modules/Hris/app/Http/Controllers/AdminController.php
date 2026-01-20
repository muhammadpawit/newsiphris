<?php

namespace Modules\Hris\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Modules\Hris\Repositories\Staff\StaffRepositoryInterface;

class AdminController extends Controller
{
    protected $staffRepo;

    public function __construct(StaffRepositoryInterface $staffRepo)
    {
        $this->staffRepo = $staffRepo;
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =[];
        $data['title'] = "HRIS Admin Dashboard";
        $rekap = $this->staffRepo->getStaffCountByAcademicType();
        $data['chartLabels'] = $rekap->pluck('kategori_akademik')->toArray();
        $data['chartSeries'] = $rekap->pluck('jumlah_staff')->toArray();
        $data['staffCountByAcademicType'] = $rekap;
        return view('hris::dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hris::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('hris::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('hris::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
