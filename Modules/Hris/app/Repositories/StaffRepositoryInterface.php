<?php
namespace Modules\Hris\Repositories;
interface StaffRepositoryInterface
{
    /**
     * Mengambil jumlah staff berdasarkan kategori akademik
     */
    public function getStaffCountByAcademicType();
}