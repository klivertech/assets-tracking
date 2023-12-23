<div>
    @if ($isOpenApproval)
    <div class="modal modal-blur d-block" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Ticket Detail</h5>
                    <button type="button" wire:click='closeModal' class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class='table-responsive'>
                                    <table class='table card-table' style='border-color: #fff'>
                                        <tbody>

                                            <tr>
                                                <td style='width: 25%'>Status</td>
                                                <td>:
                                                @if ($this->ticketDetails->status == 0)
                                                    <span class="badge bg-orange-lt">Waiting Approval</span>

                                                @elseif ($this->ticketDetails->status == 1)
                                                   <span class="badge bg-green-lt">Approved</span> on {{ $this->ticketDetails->action_date }}

                                                @elseif ($this->ticketDetails->status == 2)
                                                    <span class="badge bg-red-lt">Rejected</span> on {{ $this->ticketDetails->action_date }}

                                                @else
                                                    <span class="badge bg-pink-lt">Expired</span>

                                                @endif
                                                </td>


                                            </tr>

                                            <tr>
                                                <td style='width: 25%'>Request by</td>
                                                <td>: {{ $this->ticketDetails->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Request Date</td>
                                                <td>: {{ $this->ticketDetails->request_date }}</td>
                                            </tr>
                                            <tr>
                                                <td>Start Date</td>
                                                <td>: {{ $this->ticketDetails->start_date }}</td>
                                            </tr>
                                            <tr>
                                                <td>From Date</td>
                                                <td>: {{ $this->ticketDetails->end_date }}</td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td>: {{ $this->ticketDetails->request_desc }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive pt-4 pb-4">
                                    <table class="table table-vcenter card-table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Asset Name</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($this->ticketItems as $ticketItem)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $ticketItem->name }}</td>
                                                    <td>{{ $ticketItem->qty }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>



                                <div class="approval-option" id="approvalOptionArea">
                                    <label class="form-label"><b>Approval Option</b></label>
                                    <div class="form-selectgroup-boxes row mb-3" id="action">
                                        <div class="col-lg-6">
                                            <label class="form-selectgroup-item">
                                                <input type="radio" wire:click='approved({{ $this->ticketDetails->ticket_id }})' name="approvaloption" value="1"
                                                    class="form-selectgroup-input" id="approvalOption">
                                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                                    <span class="me-3">
                                                        <span class="form-selectgroup-check"></span>
                                                    </span>
                                                    <span class="form-selectgroup-label-content">
                                                        <span
                                                            class="form-selectgroup-title strong mb-1 text-success">Accept</span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="approvaloption" value="2"
                                                    class="form-selectgroup-input">
                                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                                    <span class="me-3">
                                                        <span class="form-selectgroup-check"></span>
                                                    </span>
                                                    <span class="form-selectgroup-label-content">
                                                        <span
                                                            class="form-selectgroup-title strong mb-1 text-danger">Decline</span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" wire:click='closeModal' data-bs-dismiss="modal" id="closeModal">Close</button>
                        {{-- <button type="button" class="btn btn-primary ms-auto buttonDetailAssignment">Assignment Detail</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
