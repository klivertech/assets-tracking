<?php

namespace App\Livewire\Assignments\Ticket;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class Approval extends Component
{
    public $isOpenApproval = 0;

    public function openModal()
    {
        $this->isOpenApproval = true;
    }
    public function closeModal()
    {
        $this->isOpenApproval = false;
    }

    #[On('trigger-approval')]
    public function approval_modal($id)
    {
        // $this->form->setCategory($id);

        $this->ticket_id = $id;

        $ticketId = $this->ticket_id;

        $this->ticketDetails = DB::table('tickets')
                            ->leftJoin('users', 'tickets.user_id', 'users.id')
                            ->where('tickets.id', $ticketId)
                            ->select('tickets.*', 'tickets.id as ticket_id', 'tickets.created_at as request_date', 'users.*')
                            ->first();

        $this->ticketItems = DB::table('tickets')
                            ->join('ticket_items', 'tickets.id', 'ticket_items.ticket_id')
                            ->join('assets', 'ticket_items.asset_id', 'assets.id')
                            ->where('tickets.id', $ticketId)
                            ->select('ticket_items.*', 'assets.*')
                            ->get();

        $this->openModal();
    }


    public function approved($id)
    {
        return redirect()->route('admin.assignment.ticket.approved', $id);
    }


    public function render()
    {
        return view('livewire.assignments.ticket.approval');
    }
}
