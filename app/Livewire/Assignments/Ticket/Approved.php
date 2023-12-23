<?php

namespace App\Livewire\Assignments\Ticket;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Livewire\Forms\ApprovalForm;

class Approved extends Component
{
    public ApprovalForm $form;

    public function mount($id)
    {
        $this->ticket_id = $id;
        $this->dispatch('DOMContentLoaded');
    }

    public function save()
    {
    // dd('abc');

        $this->validate();

        try {
            $this->form->store();

            $this->reset();
            $this->closeModal();
            $this->dispatch('notification',
                            status:'success',
                            position:'top-end',
                            title: 'Success',
                            button: 'false',
                            timer: '1500');

        } catch (\Throwable $e) {

            $this->dispatch('notification',
                            status:'error',
                            position:'center',
                            title: 'Something went wrong',
                            button: 'false',
                            timer: '3500');


        }

    }

    public function render()
    {

        $this->ticketDetails = DB::table('tickets')
                            ->leftJoin('users', 'tickets.user_id', 'users.id')
                            ->where('tickets.id', $this->ticket_id)
                            ->select('tickets.*', 'tickets.id as ticket_id', 'tickets.created_at as request_date', 'users.*')
                            ->first();

        $this->ticketItems = DB::table('tickets')
                            ->join('ticket_items', 'tickets.id', 'ticket_items.ticket_id')
                            ->join('assets', 'ticket_items.asset_id', 'assets.id')
                            ->where('tickets.id', $this->ticket_id)
                            ->select('ticket_items.*', 'assets.*')
                            ->get();

        $this->assetList = DB::table('tickets')
                        ->join('ticket_items', 'tickets.id', 'ticket_items.ticket_id')
                        ->join('assets', 'ticket_items.asset_id', 'assets.id')
                        ->where('tickets.id', $this->ticket_id)
                        ->select('ticket_items.qty', 'assets.name', 'assets.id as asset_id')
                        ->get();

        return view('livewire.assignments.ticket.approved', ['tikcetDetails' => $this->ticketDetails], ['ticketItems' => $this->ticketItems], ['assetList' => $this->assetList]);
    }
}
