<?php
namespace Modules\Hris\Repositories\Staff;
interface StaffRepositoryInterface
{
    /**
     * Mengambil jumlah staff berdasarkan kategori akademik
     */
    public function getStaffCountByAcademicType();
}