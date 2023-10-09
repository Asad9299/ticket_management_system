<?php

namespace App\Http\Controllers;

use App\Events\TicketUpdateEmail;
use App\Http\Requests\CreateTicketRequest;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Ticket::listOfTickets();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="' . route("tickets.show", $row->id) . '" class="edit btn btn-primary btn-sm " >View</a>';

                        $btn .= '<a href="' . route("tickets.edit", $row->id) . '" class="edit btn btn-secondary btn-sm ms-1 " >Edit</a>';

                        return $btn;

                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('tickets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = auth()->user()->getUsers();
        return view('tickets.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTicketRequest $request)
    {
        $data = $request->all();
        $data['assigned_by'] = auth()->user()->id;
        $saveResponse = Ticket::createTicket($data);
        if($saveResponse) {
            event(new TicketUpdateEmail($saveResponse->id));
            Session::flash('success', 'Ticket has been Created Successfully.');
            return to_route('tickets.index');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticketDetails = $ticket->getDetails();
        $ticketDetails->assigned_by = $ticket->userDetails->name;
        return view('tickets.show', ['ticket' => $ticketDetails]);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = auth()->user()->getUsers();
        $statuses = ['pending', 'resolved', 'reopened', 'closed']; 
        $ticket = Ticket::findOrFail($id);
        return view('tickets.edit', compact('users', 'ticket', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTicketRequest $request, $id)
    {
        $data = $request->all();
        $data['assigned_by'] = auth()->user()->id;
        $ticket = Ticket::findOrFail($id);

        

        $updateResponse = $ticket->updateTicket($data);
        if($updateResponse) {
            if($request->status != $ticket->status) {
                event(new TicketUpdateEmail($ticket->id));
            }
            Session::flash('success', 'Ticket has been Updated Successfully.');
            return to_route('tickets.index');
        }
        return redirect()->back();
    }

    /**
     * Close the Ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function closeTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $closeResponse = $ticket->closeTicket();
        if($closeResponse) {
            event(new TicketUpdateEmail($ticket->id));
            Session::flash('success', 'Ticket has been Closed Successfully.');
            return to_route('tickets.index');
        }
        return redirect()->back();
    }
}
