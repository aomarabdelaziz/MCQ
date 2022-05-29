@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/datatables.css') }}">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
@endpush
@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('User Dashboard') }}</h2>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->

    @if(session('success'))
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>


        </svg>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                {{ session('success') }}
            </div>
        </div>
    @endif


    <div class="card-styles">
        {!! $dataTable->table(['class' => 'table table-hover table-bordered table-striped w-100'], true) !!}
    </div>
@endsection
@push('js')
    <script src="{{ asset('dist/js/datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    {!! $dataTable->scripts() !!}

    <script>
        $('#creatorexamsindexdatatable-table').on('click', '.btn-delete[data-remote]', function (e) {

            var url = $(this).data('remote');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed)
                {
                    $.ajax(
                        {
                            url: url,
                            type: 'post', // replaced from put
                            dataType: "JSON",
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (response)
                            {

                                Swal.fire(
                                    'Access Updated!',
                                    'Your url link access has been updated.',
                                    'success'
                                )
                                document.querySelector('.dt-buttons .buttons-reload').click()
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText); // this line will save you tons of hours while debugging
                                // do something here because of error
                            }
                        });


                }
            })
        });
    </script>
@endpush
