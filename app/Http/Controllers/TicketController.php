<?php

namespace App\Http\Controllers;

use Response;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Ticket;
use App\Models\Assignment;
use App\Models\TicketItem;
use Illuminate\Http\Request;
use App\Models\AssignmentLog;
use App\Models\AssignmentDetail;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class TicketController extends Controller
{

    public function assetListAssignment($id)
    {
        $assetList = DB::table('tickets')
                        ->join('ticket_items', 'tickets.id', 'ticket_items.ticket_id')
                        ->join('assets', 'ticket_items.asset_id', 'assets.id')
                        ->where('tickets.id', $id)
                        ->select('ticket_items.ticket_id','ticket_items.qty', 'assets.name', 'assets.id as asset_id')
                        ->get();


            return Response::json([
                'data' => $assetList
            ]);

    }

    public function getUnitList($asset_id, $ticket_id)
    {
        $getItems = DB::table('ticket_items')
                    ->join('assets', 'ticket_items.asset_id', 'assets.id')
                    ->join('units', 'assets.id', 'units.asset_id')
                    ->where('ticket_items.asset_id', $asset_id)
                    ->where('ticket_items.ticket_id', $ticket_id)
                    ->where('units.is_available', '1')
                    ->get();


            return Response::json([
                'data' => $getItems
            ]);


    }


    public function approvalStore(Request $request)
    {
        $response = array();
        $ticketId = $request->id;
        $unitList = $request->unitid;

        if ($request->approvalvalue == '1') {

            try {

                DB::beginTransaction();

                $ticket = Ticket::where('id', $ticketId)->first();
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

                Ticket::where('id', $ticketId)
                        ->update([
                                'status' => '1',
                                'action_desc' => $request->action_desc,
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
                    'log_maker' => $request->created_by,
                    'log_notes' => $request->action_desc,
                ]);


                foreach ($unitList as $key => $value){

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

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                $response = array('status' => 'failed', 'errors' => $e->getMessage());
            }

        } else {

            try {

                DB::beginTransaction();

                Ticket::where('id', $ticketId)
                        ->update([
                                'status' => '2',
                                'action_desc' => $request->action_desc,
                                'action_date' => Carbon::now()
                            ]);

                $response = array('status' => 'success');

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                $response = array('status' => 'failed', 'errors' => $e->getMessage());
            }

        }


        return response()->json($response, 202);



    }


}
