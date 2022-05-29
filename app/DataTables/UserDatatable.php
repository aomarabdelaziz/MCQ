<?php

namespace App\DataTables;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDatatable extends DataTable
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

                return  $data->exam_name;

            })
            ->addColumn('exam_visits',   function (Exam $data){

                return $data->exam_visits->visits;


            })
            ->addColumn('number_of_questions',   function (Exam $data){

                return $data->number_of_questions;

            })
            ->addColumn('category',   function (Exam $data){

                return $data->category_id;


            })
            ->addColumn('difficulty', function(Exam $data){

                return ucfirst($data->difficulty);


            })
            ->addColumn('type', function(Exam $data){

                return ucfirst($data->type);


            })
            ->addColumn('ending_in', function(Exam $data){

                return  'After ' . $data->deactivated_at->diffForHumans();

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


        $participateRoute = route('user.exam.participate' ,  ['exam_slug' => $data->slug]);
        $btn =  "<a href='$participateRoute' class='view btn btn-info btn-sm mr-5'>Participate</a>";

        return $btn;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|mixed
     */
    public function query()
    {

        DB::enableQueryLog();
        $query =  Exam::with('exam_visits')->where('deactivated_at' , '>' , now() )->get();


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
                'id' => 'exam_visits',
                'data' => 'exam_visits',
                'title' => 'Visits',
                'footer' => 'Visits',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'width' => '10',

                'class' => 'text-center'
            ],

            [
                'id' => 'number_of_questions',
                'data' => 'number_of_questions',
                'title' => 'Number Of Questions',
                'footer' => 'Number Of Questions',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'class' => 'text-center',
                'width' => '10',
            ],

            [
                'id' => 'category',
                'data' => 'category',
                'title' => 'Category',
                'footer' => 'Category',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'width' => '180',

                'class' => 'text-center'
            ],
            [
                'id' => 'difficulty',
                'data' => 'difficulty',
                'title' => 'Difficulty',
                'footer' => 'Difficulty',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'width' => '80',

                'class' => 'text-center'
            ],
            [
                'id' => 'type',
                'data' => 'type',
                'title' => 'Type',
                'footer' => 'Type',
                'searchable' => true,
                'orderable' => true,
                'exportable' => true,
                'printable' => true,
                'width' => '80',

                'class' => 'text-center'
            ],
            [
                'id' => 'ending_in',
                'data' => 'ending_in',
                'title' => 'Ending at',
                'footer' => 'Ending at',
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
        return 'Users_' . date('YmdHis');
    }
}
