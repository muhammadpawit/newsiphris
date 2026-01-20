<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DataTableHelper
{
    public static function gridButtons($id, $title, $routePrefix)
    {
        $buttons = '<div class="btn-group" role="group" style="gap: 5px;">';

        // 1. Detail (Modal)
        if (Auth::user()->can($routePrefix . '.show')) {
            $buttons .= '
                <a href="javascript:void(0)" onclick="showDetail(' . $id . ')" class="btn btn-sm btn-info text-white" title="Detail">
                    <i class="ri-information-line"></i>
                </a>';
        }

        // 2. Edit (Modal)
        if (Auth::user()->can($routePrefix . '.edit')) {
            $buttons .= '
                <a href="javascript:void(0)" onclick="editData(' . $id . ')" class="btn btn-sm btn-warning text-white" title="Edit">
                    <i class="ri-edit-line"></i>
                </a>';
        }

        // 3. Delete
        if (Auth::user()->can($routePrefix . '.delete')) {
            $buttons .= '
                <button type="button" class="btn btn-sm btn-danger" title="Hapus" 
                    onclick="confirmDelete(' . $id . ', \'' . addslashes($title) . '\')">
                    <i class="ri-delete-bin-line"></i>
                </button>';
        }

        $buttons .= '</div>';
        return ($buttons == '<div class="btn-group" role="group" style="gap: 5px;"></div>') ? '-' : $buttons;
    }

    // HELPER BARU UNTUK BADGE STATUS
    public static function statusBadge($status)
    {
        $status = strtolower($status);
        $badges = [
            'active'        => 'bg-success',
            'development'   => 'bg-warning text-dark',
            'inactive'      => 'bg-danger'
        ];

        $class = $badges[$status] ?? 'bg-secondary';
        $label = ucfirst($status);

        return '<span class="badge ' . $class . '">' . $label . '</span>';
    }

    public static function applySmartFilters(Builder $query, Request $request, $tablePrefix = null)
    {
        $modelTable = $query->getModel()->getTable();
        $targetTable = $tablePrefix ?: $modelTable;
        $columns = Schema::getColumnListing($targetTable);

        foreach ($request->all() as $key => $value) {
            if ($value === null || $value === '' || !in_array($key, $columns)) {
                continue;
            }

            $qualifiedColumn = $targetTable . '.' . $key;

            if (str_ends_with($key, '_id') || in_array($key, ['id', 'status', 'color'])) {
                $query->where($qualifiedColumn, $value);
            } else {
                $query->where($qualifiedColumn, 'like', "%{$value}%");
            }
        }

        return $query;
    }
}