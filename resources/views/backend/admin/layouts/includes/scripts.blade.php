<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{asset('assets/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
{{-- <script src="{{asset('assets/modules/chart.min.js')}}"></script> --}}
<script src="{{asset('assets/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
<script src="{{asset('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
<script src="{{asset('assets/modules/summernote/summernote-bs4.js')}}"></script>
<script src="{{ asset('plugins/toastr/toastr.js') }}"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
<script src="{{asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/modules/select2/dist/js/select2.full.min.js')}}"></script>

<!-- Page Specific JS File -->
{{--<script src="{{ asset('assets/js/page/index.js') }}"></script>--}}

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- Plugins -->
{{--<script src="{{ asset('plugins/color-picker/bootstrap-colorpicker.js') }}"></script>--}}

@stack('page-specific-js')
@stack('custom-scripts')
<script type="text/javascript">
    @if (session('success'))
    toastr.success("{{ session('success') }}", "Success");
    @elseif (session('error'))
    toastr.error("{{ session('error') }}", "Error");
    @elseif (session('info'))
    toastr.info("{{ session('info') }}", "Info");
    @elseif (session('warning'))
    toastr.warning("{{ session('warning') }}", "Warning");
    @endif

    $('[data-toggle="tooltip"]').tooltip()

    function handleFileSelect(inputElement, previewContainer) {
        inputElement.on('change', function () {
            const files = Array.from(this.files);
            previewContainer.html(''); // Clear previous previews
            previewContainer.empty(); // Clear previous previews
            let i = files.length;
            let j = 0;
            files.forEach(function (file, index) {
                j++;
                if (j <= i) {
                    const reader = new FileReader();

                    reader.onload = function (event) {
                        const imagePreview = `
                        <div class="image-preview" data-file-index="${index}">
                            <img src="${event.target.result}" alt="Image Preview">
                            <button type="button" class="remove-image" data-file-index="${index}"><i class="fa fa-times text-white"></i></button>
                        </div>`;
                        previewContainer.append(imagePreview);
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Handle removing images
            previewContainer.off('click', '.remove-image').on('click', '.remove-image', function () {
                const fileIndex = $(this).data('file-index');
                const dt = new DataTransfer();
                const updatedFiles = Array.from(inputElement[0].files).filter((_, i) => i !== fileIndex);

                updatedFiles.forEach(file => dt.items.add(file));
                inputElement[0].files = dt.files;

                // Remove the preview
                $(this).closest('.image-preview').remove();

                // Update indices in the preview
                updatePreviewIndices(previewContainer);
            });
        });
    }

    // Function to update data-file-index attributes in previews
    function updatePreviewIndices(previewContainer) {
        previewContainer.children('.image-preview').each(function (newIndex) {
            $(this).attr('data-file-index', newIndex);
            $(this).find('.remove-image').attr('data-file-index', newIndex);
        });
    }

    $(document).ready(function () {
        // Function to handle image preview for new uploads

        // Initialize file uploaders and preview containers
        $('.file-uploader').each(function () {
            const inputElement = $(this);
            const previewContainer = $('#' + inputElement.data('preview-container'));
            handleFileSelect(inputElement, previewContainer);
        });
    });

</script>


<script type="text/javascript">
    $(document).on('click', '.delete-btn', function () {
        $('#deleteModal').modal('toggle');
        console.log($(this).data('href'));
        $('#deleteForm').prop('action', $(this).data('href'))
    });
</script>
