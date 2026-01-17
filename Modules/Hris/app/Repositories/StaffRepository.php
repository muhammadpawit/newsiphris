<?php
namespace Modules\Hris\Repositories;


use Illuminate\Support\Facades\DB;

class StaffRepository implements StaffRepositoryInterface
{
    public function getStaffCountByAcademicType()
    {
        return DB::table('informasi_staff')
            ->leftJoin('staff_riwayat_aktifitas', function ($join) {
                $join->on('staff_riwayat_aktifitas.staff_id', '=', 'informasi_staff.staff_id')
                     ->where('staff_riwayat_aktifitas.status', '=', 1);
            })
            ->select(
                DB::raw("CASE 
                    WHEN informasi_staff.is_akademik = 1 THEN 'Akademik'
                    WHEN informasi_staff.is_akademik = 0 THEN 'Non Akademik'
                    WHEN informasi_staff.is_akademik = 2 THEN 'Tenaga Ahli'
                    ELSE 'Lainnya' 
                END as kategori_akademik"),
                DB::raw("COUNT(informasi_staff.staff_id) as jumlah_staff")
            )
            ->where('staff_riwayat_aktifitas.status', 1)
            ->whereNotNull('informasi_staff.is_akademik')
            ->groupBy('informasi_staff.is_akademik')
            ->orderBy('informasi_staff.is_akademik')
            ->get();
    }
}