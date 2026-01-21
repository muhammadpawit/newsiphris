<?php

namespace Modules\Hris\Http\Controllers;

use App\Helpers\DataTableHelper;
use App\Http\Controllers\Controller;
use App\Models\NewhrisMenu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Hris\Repositories\Menu\MenuRepositoryInterface;
use Yajra\DataTables\DataTables;

class MenuAksesController extends Controller
{
    protected $modulRepo;
    protected $model;
    protected $viewPath;

    public function __construct(MenuRepositoryInterface $modulRepo)
    {
        // Pastikan Anda sudah membuat MenuRepository dan mem-binding-nya di ServiceProvider
        $this->modulRepo = $modulRepo;
        $this->model    = NewhrisMenu::class;
        $this->viewPath  = 'hris::daftar-menu.page';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->modulRepo->getQuery()->with(['roles', 'parent']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('parent', function($row) {
                    return $row->parent->title ?? '<span class="badge badge-soft-primary">Main Menu</span>';
                })
                ->addColumn('roles_assignment', function($row) {
                    // Menampilkan badge role agar rapi (sesuai gambar yang Anda unggah)
                    $badges = '';
                    foreach ($row->roles as $role) {
                        $badges .= '<span class="badge badge-soft-info me-1">' . $role->name . '</span>';
                    }
                    return $badges ?: '<span class="text-muted">Tidak ada akses</span>';
                })
                ->addColumn('action', function($row) {
                    // Gunakan Helper Anda untuk merender tombol
                    return \App\Helpers\DataTableHelper::gridButtons($row->id, $row->title, 'hris.daftar-menu');
                })
                ->rawColumns(['parent', 'roles_assignment', 'action']) // PENTING: Agar HTML dirender, bukan ditampilkan sebagai teks
                ->make(true);
        }
        
        $data['title'] = 'Manajemen Akses Menu';
        $data['roles'] = \App\Models\Role::all(); // Pastikan data roles dikirim untuk modal
        return view("hris::daftar-menu.page.index", $data);
    }

    /**
     * Fungsi AJAX untuk update role per menu
     */
    public function updateRole(Request $request)
    {
        try {
            $menu = $this->modulRepo->find($request->menu_id);
            
            if (!$menu) {
                return response()->json(['success' => false, 'message' => 'Menu tidak ditemukan'], 404);
            }

            // Sync ke tabel pivot newhris_menu_role
            $menu->roles()->sync($request->roles ?? []);

            // Clear Cache Sidebar agar perubahan langsung terasa
            Cache::flush();

            return response()->json([
                'success' => true,
                'message' => 'Hak akses menu ' . $menu->title . ' berhasil diperbarui.'
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
        try {
            // Eager load relasi roles agar Select2 di modal otomatis terisi
            $item = $this->modulRepo->getQuery()->with('roles')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $menu = $this->modulRepo->update($id, $request->all());

            // Update relasi di tabel pivot newhris_menu_role
            $menu->roles()->sync($request->roles ?? []);

            Cache::flush(); // Bersihkan cache agar perubahan langsung muncul di sidebar

            return response()->json(['success' => true, 'message' => 'Konfigurasi menu berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}