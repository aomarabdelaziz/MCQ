<?php

namespace App\DataTables;

use App\Models\Exam;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CreatorRequestDataTable extends DataTable
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

            ->addColumn('exam_name',   function (Request $data) {


                return  $data->exams->exam_name;

            })
            ->addColumn('user_name',   function (Request $data){



                $name  = User::find($data->user_id)->name;
                return $name;


            })
            ->addColumn('actions', function(Request $data){

                return $this->getActionColumns($data);

            })
            ->rawColumns(['actions']);


    }

    /**
     * @param Exam $data
     * @return string
     */
    public function getActionColumns(Request $data) : string
    {



        $enable_disableAccessRoute = route('dashboard.creator.requests' , [ 'slug' => auth()->guard('creators')->user()->slug , 'exam_id' => $data->exams->id , 'user_id' => $data->user_id]);
        $btn =   '<a href="javascript:void(0)" class="btn-delete btn btn-success btn-sm" data-remote="' . $enable_disableAccessRoute . '">Enable Request Access</button>';

        return $btn;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|mixed
     */
    public function query()
    {

        DB::enableQueryLog();
        $query =  Request::whereHas('exams', function ($q) {
            return $q->where('creator_id' , auth()->guard('creators')->user()->id);
        })->whereAccess(false)->get();



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
                'id' => 'user_name',
                'data' => 'user_name',
                'title' => 'Username',
                'footer' => 'Username',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'width' => '10',

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
        return 'Users_' . date('YmdHis');
    }
}
