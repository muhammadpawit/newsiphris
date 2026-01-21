<?php

namespace Modules\Hris\Http\Controllers;

use App\Exports\RoleExport;
use App\Helpers\DataTableHelper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Hris\Repositories\Role\RoleRepositoryInterface;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    protected $modulRepo;
    protected $model;
    protected $viewPath;

    public function __construct(RoleRepositoryInterface $modulRepo)
    {
        $this->modulRepo = $modulRepo;
        $this->model     = Role::class;
        $this->viewPath  = 'hris::daftar-role.page';
    }

    public function index(Request $request)
    {
        $data['title'] = 'Daftar Role';
        
        if ($request->ajax()) {
            $query = $this->modulRepo->getQuery(); 

            return DataTables::of($query)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    DataTableHelper::applySmartFilters($query, $request, $this->model);
                }, true) 
                ->editColumn('status', function($row) {
                    // Menggunakan Helper Status Badge
                    return DataTableHelper::statusBadge($row->status);
                })
                ->addColumn('action', function($row){
                    // Menggunakan Helper Action Buttons
                    return DataTableHelper::gridButtons($row->id, $row->title, 'hris.daftar-role');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        
        return view("{$this->viewPath}.index",$data);
    }

    public function create()
    {
        return view('hris::daftar-module.page.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $this->modulRepo->store($validated);
            return response()->json([
                'success' => true,
                'message' => 'Data module berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $item = $this->modulRepo->find($id);
        
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    public function edit($id)
    {
        $data['module'] = $this->modulRepo->find($id);
        return view("{$this->viewPath}.edit", $data);
    }

    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $this->modulRepo->update($id, $request->all());
            return response()->json(['success' => true, 'message' => 'Module berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id) 
    {
        // 1. Cari data module terlebih dahulu
        $module = $this->modulRepo->find($id);

        if (!$module) {
            return response()->json([
                'success' => false, 
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        
        if ($module && in_array($module->name, ['administrator', 'superadmin'])) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal! Role ini tidak dapat dihapus.'
            ], 422); // Error 422: Unprocessable Entity
        }

        try {
            // 3. Eksekusi hapus jika validasi lolos
            $this->modulRepo->delete($id);
            
            return response()->json([
                'success' => true, 
                'message' => 'Module berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportExcel(Request $request) 
{
    // Mengambil keyword 'search' dari URL (?search=...)
    $search = $request->get('search');

    return Excel::download(
        new RoleExport($this->modulRepo, $search), 
        'daftar-role-' . date('Ymd') . '.xlsx'
    );
}

public function exportPdf(Request $request)
{
    // 1. Ambil Query dari Repo
    $query = $this->modulRepo->getQuery();

    // 2. Terapkan Smart Filter (Sama dengan Index & Excel)
    DataTableHelper::applySmartFilters($query, $request, $this->model);

    // 3. Tambahkan filter search box jika ada
    if ($request->filled('search')) {
        $search = $request->get('search');
        $query->where(function($q) use ($search) {
            $q->where('newhris_roles.name', 'like', "%{$search}%")
              ->orWhere('newhris_roles.guard', 'like', "%{$search}%");
        });
    }

    // 4. Eksekusi Query
    $items = $query->get();

    // 5. Generate PDF
    $pdf = Pdf::loadView("{$this->viewPath}.pdf", compact('items'));
    $pdf->setPaper('a4', 'landscape');
    
    return $pdf->download('daftar-role-' . date('Ymd') . '.pdf');
}
}
