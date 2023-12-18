<div>
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Assets
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">

                            <livewire:AssetManagement.Asset.Create>
                            <livewire:AssetManagement.Asset.Edit>
                            <livewire:AssetManagement.Asset.Delete>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-body">

                        <livewire:table.AssetTable>
                            {{-- <livewire:AssetsTable> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>



{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>

    window.addEventListener('notification', event => {
        Swal.fire({
            position: event.detail.position,
            icon: event.detail.status,
            title: event.detail.title,
            showConfirmButton: event.detail.button,
            timer: event.detail.timer
        })
    });

</script>
