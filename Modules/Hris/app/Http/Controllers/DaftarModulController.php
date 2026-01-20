<?php

namespace Modules\Hris\Http\Controllers;

use App\Exports\ModulExport;
use App\Helpers\DataTableHelper;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Hris\Repositories\Module\ModulRepositoryInterface;
use Yajra\DataTables\DataTables;

class DaftarModulController extends Controller
{
    protected $modulRepo;

    public function __construct(ModulRepositoryInterface $modulRepo)
    {
        $this->modulRepo = $modulRepo;
    }

    public function index(Request $request)
    {
        $data['title'] = 'Daftar Module Aplikasi';
        
        if ($request->ajax()) {
            $query = $this->modulRepo->getQuery(); 

            return DataTables::of($query)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    DataTableHelper::applySmartFilters($query, $request, 'modul_aplikasi');
                }, true) 
                ->editColumn('status', function($row) {
                    // Menggunakan Helper Status Badge
                    return DataTableHelper::statusBadge($row->status);
                })
                ->addColumn('action', function($row){
                    // Menggunakan Helper Action Buttons
                    return DataTableHelper::gridButtons($row->id, $row->title, 'hris.daftar-module');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        
        return view('hris::daftar-module.page.index', $data);
    }

    public function create()
    {
        return view('hris::daftar-module.page.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url'   => 'required|string|unique:modul_aplikasi,url',
            'icon'  => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:development,active,inactive'
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
        return view('hris::daftar-module.page.edit', $data);
    }

    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'url'    => 'required|string|unique:modul_aplikasi,url,' . $id,
            'status' => 'required|in:development,active,inactive',
            'icon'   => 'nullable|string|max:100',
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
        new ModulExport($this->modulRepo, $search), 
        'daftar-module-' . date('Ymd') . '.xlsx'
    );
}

public function exportPdf(Request $request)
{
    // 1. Ambil Query dari Repo
    $query = $this->modulRepo->getQuery();

    // 2. Terapkan Smart Filter (Sama dengan Index & Excel)
    DataTableHelper::applySmartFilters($query, $request, 'modul_aplikasi');

    // 3. Tambahkan filter search box jika ada
    if ($request->filled('search')) {
        $search = $request->get('search');
        $query->where(function($q) use ($search) {
            $q->where('modul_aplikasi.title', 'like', "%{$search}%")
              ->orWhere('modul_aplikasi.url', 'like', "%{$search}%");
        });
    }

    // 4. Eksekusi Query
    $items = $query->get();

    // 5. Generate PDF
    $pdf = Pdf::loadView('hris::daftar-module.page.pdf', compact('items'));
    $pdf->setPaper('a4', 'landscape');
    
    return $pdf->download('daftar-module-' . date('Ymd') . '.pdf');
}

}