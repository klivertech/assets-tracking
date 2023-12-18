<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Unit;
use App\Models\Ticket;
use App\Models\AssignmentLog;
use Livewire\Attributes\Rule;
use App\Models\AssignmentDetail;
use Illuminate\Support\Facades\DB;

class ApprovalForm extends Form
{
    public ?Approval $form;

    #[Rule('required')]
    public $ticket_id;

    #[Rule('required')]
    public $unit_id;

    // #[Rule('required')]
    // public $category_id;

    // public $description;

    public function setApproval(Approval $approval)
    {
        $this->approval = $approval;

        $this->ticket_id = $approval->ticket_id;
        $this->unit_id = $approval->unit_id;
        $this->created_by = $approval->created_by;
        $this->action_desc = $approval->action_desc;

        $this->approvalvalue = $approval->approvalvalue;

    }

    public function store()
    {

        if ($this->approvalvalue == '1') {

            $ticket = Ticket::where('id', $this->ticket_id)->first();
            $ticketItem = TicketItem::where('ticket_id', $ticket->id)->get();

            $assignment = Assignment::create([
                'number' => $ticket->number,
                'user_id' => $ticket->user_id,
                'start_date' => $ticket->start_date,
                'end_date' => $ticket->end_date,
                'total_asset' => $ticketItem->count(),
                'total_unit' => $ticketItem->sum('qty'),
                'status' => '1'
            ]);

            Ticket::where('id', $this->ticket_id)
                    ->update([
                            'status' => '1',
                            'action_desc' => $this->action_desc,
                            'action_date' => Carbon::now()
                        ]);

            AssignmentLog::create([
                'assignment_id' => $assignment->id,
                'status' => '1',
                'log_date' => $ticket->action_date,
                'log_maker' => $ticket->user_id,
                'log_notes' => $ticket->action_desc,
            ]);

            AssignmentLog::create([
                'assignment_id' => $assignment->id,
                'status' => '2',
                'log_date' => Carbon::now(),
                'log_maker' => $this->created_by,
                'log_notes' => $this->action_desc,
            ]);


            foreach ($this->unit_id as $key => $value){

                 AssignmentDetail::create([
                    'assignment_id' => $assignment->id,
                    'asset_id' => '0',
                    'unit_id' => $value
                ]);

                $getAssetId = Unit::where('id', $value)->first();

                AssignmentDetail::where('unit_id', $getAssetId->id)
                                ->update(['asset_id' => $getAssetId->asset_id]);

                Unit::where('id', $value)
                    ->update(['is_available' => '0']);

            }

            $response = array('status' => 'success');


        } else {

            Ticket::where('id', $this->ticket_id)
            ->update([
                    'status' => '2',
                    'action_desc' => $this->action_desc,
                    'action_date' => Carbon::now()
                ]);

        }

    }
}
