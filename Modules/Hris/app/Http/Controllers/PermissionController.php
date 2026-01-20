<?php

namespace Modules\Hris\Http\Controllers;

use App\Exports\PermissionExport;
use App\Helpers\DataTableHelper;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Hris\Repositories\Permission\PermissionRepositoryInterface;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    protected $modulRepo;
    protected $model;
    protected $viewPath;

    public function __construct(PermissionRepositoryInterface $modulRepo)
    {
        $this->modulRepo = $modulRepo;
        $this->model     = Permission::class;
        $this->viewPath  = 'hris::daftar-permission.page';
    }

    public function index(Request $request)
    {
        $data['title'] = 'Daftar Permission';
        
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
                    return DataTableHelper::gridButtons($row->id, $row->title, 'hris.daftar-permission');
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
            // Daftar suffix yang ingin dibuat otomatis
            $actions = ['access', 'show', 'create', 'edit', 'delete'];
            $baseName = $request->name;

            foreach ($actions as $action) {
                // Menggabungkan hris.daftar-role dengan suffix (misal: .access)
                $permissionName = "{$baseName}.{$action}";

                // Gunakan Repository untuk menyimpan tiap permission
                // Pastikan repository Anda mendukung pengecekan duplicate (updateOrCreate/firstOrCreate)
                $this->modulRepo->store([
                    'name' => $permissionName,
                    'guard_name' => 'web' // Sesuaikan dengan guard Anda
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Daftar permission berhasil digenerate otomatis!'
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

        // 2. Cek apakah statusnya 'tidak aktif'
        // Sesuaikan string 'tidak aktif' dengan value yang Anda simpan di database
        if ($module->status !== 'tidak aktif') {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal! Hanya module dengan status Tidak Aktif yang dapat dihapus.'
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
            new PermissionExport($this->modulRepo, $search), 
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
