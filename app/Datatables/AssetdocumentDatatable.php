<?php

namespace App\Datatables;

use App\Models\AssetDocument;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Asset;

class AssetdocumentDatatable extends Datatable
{
    public $slug = 'assetdocument';

    public function datasource()
    {
        return AssetDocument::with('asset')->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('cngpump_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Asset'))
                ->data('asset_id', function (AssetDocument $assetdocument) {
                    return $assetdocument->asset_id ? $assetdocument->asset->name . ' - ' . $assetdocument->asset->type : null;
                })
                ->filterOptions(Asset::selectRaw('id, CONCAT(name, " - ", type) as label')->distinct()->pluck('label', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('asset_id', $value);
                }),

            Column::add(__('Name'))
                ->data('name'),

            Column::add(__('Document url'))
                ->data('path', function (AssetDocument $assetdocument) {
                    return '<a href="'.asset($assetdocument->document_url).'" target="_blank" style="color:#007bff;font-weight:bold;">'.__('View').'</a>';
                })->notSortable()->notSearchable(),

            Column::add()
                ->width('20px')
                ->actions(function (AssetDocument $assetdocument) {
                    return join([
                         Button::edit('backend.asset.assetdocument.edit', $assetdocument),
                         Button::delete('backend.asset.assetdocument.destroy', $assetdocument),
                    ]);
                }),
        ];
    }
}
