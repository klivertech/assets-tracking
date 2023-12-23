<div>
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Approved - Select Item
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="form-label pb-4">Select Items</p>

                                        <form wire:submit="save">
                                            @csrf
                                            <div id="selectItems" class="pb-4">
                                            </div>

                                            <input type="text" wire:model="form.ticket_id" value="{{ $this->ticketDetails->ticket_id }}"
                                                id="ticketId">

                                            <button type="submit" class="btn btn-primary ms-auto">Submit</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="form-label pb-2">Ticket Information</p>
                                        <div class='table-responsive'>


                                            <label>Request by</label>
                                            <p class="bold">{{ $this->ticketDetails->name }}</p>

                                            <label>Request Date</label>
                                            <p class="text-bold">{{ $this->ticketDetails->request_date }}</p>

                                            <label>Start Date</label>
                                            <p class="text-bold">{{ $this->ticketDetails->start_date }}</p>

                                            <label>From Date</label>
                                            <p class="text-bold">{{ $this->ticketDetails->end_date }}</p>

                                            <label>Description</label>
                                            <p class="text-bold">{{ $this->ticketDetails->request_desc }}</p>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script> --}}

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> --}}


@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
@endsection


@section('script')
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // console.log('abc');
            getAssetList(document.getElementById('ticketId').value);
        });

        // $(document).ready(function () {
        //     getAssetList(document.getElementById('ticketId').value);

        // })

        function getAssetList(x) {
            var itemList = document.getElementById('itemList');
            // while (itemList.firstChild) {
            //     itemList.removeChild(itemList.firstChild);
            // }

            axios.post("{{ route('admin.assignment.assignments.assetlistassignment', '') }}" + '/' + x, {
                    _token: "{{ csrf_token() }}"
                })
                .then(function(response) {
                    var selectItems = document.getElementById('selectItems');
                    selectItems.innerHTML = '';

                    response.data.data.forEach(function(value) {
                        var div = document.createElement('div');
                        div.className = 'pb-4';
                        div.innerHTML = '<p><b>' + value.name + '</b> (' + value.qty + (value.qty > 1 ? ' Units' : ' Unit') + ')</p>' +
                            '<input value="' + value.qty + '" id="unitQty' + value.asset_id + '" hidden>' +
                            '<input name="assetid[]" value="' + value.asset_id + '" hidden></input>' +
                            '<select class="form-select selectitemsform" name="unitid[]" id="selectitemsform' + value.asset_id + '" multiple="multiple" required></select>';

                        selectItems.appendChild(div);

                        getUnitList(value.asset_id, value.ticket_id);
                    });
                })
                .catch(function(error) {
                    if (error.response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.response.data.errors
                        });
                    } else {
                        console.error(error);
                    }
                });
        }

        function getUnitList(x, y) {
            axios.post(`{{ route('admin.assignment.assignments.getunitlist', ['', '']) }}/${x}/${y}`, {
                    _token: "{{ csrf_token() }}"
                })
                .then(function(response) {
                    var selectitemsform = document.getElementById('selectitemsform' + x);


                    console.log(response.data)
                    response.data.data.forEach(function(value) {
                        var option = new Option(value.serial_number + ' - ' + value.condition, value.id);
                        selectitemsform.appendChild(option);
                    });

                    var unitQty = document.getElementById('unitQty' + x);
                    new Choices(selectitemsform, {
                        removeItemButton: true,
                        maxItemCount: unitQty.value,
                        placeholder: true
                    });
                })
                .catch(function(error) {
                    if (error.response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.response.data.errors
                        });
                    } else {
                        console.error(error);
                    }
                });
        }
    </script>
@endsection
