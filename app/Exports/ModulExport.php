<?php

namespace App\Exports;

use Modules\Hris\Repositories\Module\ModulRepositoryInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Helpers\DataTableHelper;

class ModulExport implements FromCollection, WithHeadings, WithMapping
{
    protected $modulRepo;
    private $rowNumber = 0;

    public function __construct(ModulRepositoryInterface $modulRepo)
    {
        $this->modulRepo = $modulRepo;
    }

    public function collection()
    {
        // 1. Ambil Query dari Repo
        $query = $this->modulRepo->getQuery();
        
        // 2. Ambil Request Global
        $request = request();

        // 3. Terapkan Smart Filter yang sama dengan Controller
        DataTableHelper::applySmartFilters($query, $request, 'modul_aplikasi');

        // 4. Tambahkan filter search box jika ada
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('modul_aplikasi.title', 'like', "%{$search}%")
                  ->orWhere('modul_aplikasi.url', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['No.', 'Nama Module', 'Slug', 'Status', 'Tgl Dibuat'];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row->title,
            $row->url,
            $row->icon,
            $row->created_at->format('d-m-Y H:i')
        ];
    }
}