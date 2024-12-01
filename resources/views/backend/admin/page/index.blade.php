@extends('backend.admin.layouts.main')
@section('title', 'Pages')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Pages</div>
@endsection
@push('style')
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @can('pages.create')
                    <div class="text-right">
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Add new page</a>
                    </div>
                @endcan
            </div>
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">All pages</h4>
                    </div>
                    <div class="card-body">
                        {{--                        <div class="table-responsive">--}}
                        {{ $dataTable->table() }}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Button trigger modal -->
    <!-- Modal -->
    @include('backend.admin.modal.delete')
@endsection
@push('custom-scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <!-- JS Libraies -->
    <script type="text/javascript">
        $(document).on('click', '.url-copy-btn', function () {
            const urlToCopy = $(this).data('href');

            if (urlToCopy) {
                if (navigator.clipboard) {
                    // Use the Clipboard API if available
                    navigator.clipboard.writeText(urlToCopy).then(function () {
                        toastr.success('Page URL copied to clipboard!');
                    }).catch(function (err) {
                        console.error('Failed to copy text: ', err);
                        alert('Failed to copy URL!');
                    });
                } else {
                    // Fallback for older browsers
                    const tempInput = $('<textarea>');
                    $('body').append(tempInput);
                    tempInput.val(urlToCopy).select();
                    document.execCommand('copy');
                    tempInput.remove();
                    toastr.success('Page URL copied to clipboard!');
                }
            } else {
                alert('No URL found to copy!');
            }
        });

    </script>
@endpush
