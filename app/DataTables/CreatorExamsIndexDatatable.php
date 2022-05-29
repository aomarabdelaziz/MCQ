<?php

namespace App\DataTables;

use App\Models\Exam;
use App\Models\Creator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CreatorExamsIndexDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)

            ->addColumn('exam_name',   function (Exam $data) {
                return $data->exam_name;

            })
            ->addColumn('exam_slug_name',   function (Exam $data){
                return $data->slug;

            })
            ->addColumn('exam_visits',   function (Exam $data){
                return $data->exam_visits->visits;
            })
            ->addColumn('request_access',   function (Exam $data){


                return  $data->request_access == true ? 'Enabled' : 'Disabled';

            })
            ->addColumn('actions', function(Exam $data){

                return $this->getActionColumns($data);

            })
            ->rawColumns(['actions' , 'request_access']);


    }

    /**
     * @param Exam $data
     * @return string
     */
    public function getActionColumns(Exam $data) : string
    {


        $viewRoute = route('creator.dashboard.show' , ['slug' => $data->creator->slug , 'exam_slug' => $data->slug]);
        $enable_disableAccessRoute = route('creator.dashboard.enable_disable_access'  , ['slug' => $data->creator->slug , 'exam_slug' => $data->slug]);
        $btn =  "<a href='$viewRoute' class='view btn btn-info btn-sm mr-5'>View</a>";

        if($data->request_access == true) {
            $btn = $btn .  '<a href="javascript:void(0)" class="btn-delete btn btn-danger btn-sm" data-remote="' . $enable_disableAccessRoute . '">Disable Access</button>';

        }
        else {
            $btn = $btn .  '<a href="javascript:void(0)" class="btn-delete btn btn-success btn-sm" data-remote="' . $enable_disableAccessRoute . '">Enable Access</button>';

        }

        return $btn;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|mixed
     */
    public function query()
    {

        DB::enableQueryLog();
        $query =  Exam::with(['creator', 'exam_visits'])->where('creator_id' , '=' , auth()->guard('creators')->user()->id)->get();


        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('creatorexamsindexdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            [
                'id' => 'exam_name',
                'data' => 'exam_name',
                'title' => 'Exam Name',
                'footer' => 'Exam Name',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'class' => 'text-center',
                'width' => '180',

            ],

            [
                'id' => 'exam_slug_name',
                'data' => 'exam_slug_name',
                'title' => 'Exam Slug Name',
                'footer' => 'Exam Slug Name',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'class' => 'text-center',
                'width' => '180',
            ],
            [
                'id' => 'exam_visits',
                'data' => 'exam_visits',
                'title' => 'Visits',
                'footer' => 'Visits',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'width' => '80',

                'class' => 'text-center'
            ],
            [
                'id' => 'request_access',
                'data' => 'request_access',
                'title' => 'Request Access',
                'footer' => 'Request Access',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'width' => '80',

                'class' => 'text-center'
            ],
            [
                'id' => 'actions',
                'data' => 'actions',
                'title' => 'Actions',
                'footer' => 'Actions',
                'searchable' => false,
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'class' => 'text-center',
                'width' => '200'
            ],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'CreatorExamsIndex_' . date('YmdHis');
    }
}
