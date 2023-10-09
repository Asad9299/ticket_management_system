<?php

namespace App\Listeners;

use App\Events\TicketUpdateEmail;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TicketUpdateEmailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TicketUpdateEmail  $event
     * @return void
     */
    public function handle(TicketUpdateEmail $event)
    {
        $ticket = Ticket::find($event->ticketId);
                
        $user = User::where('id', $ticket->assigned_to)->first()->toArray();

        $data = [
            'name'        => $user['name'],
            'email'       => $user['email'],
            'title'       => $ticket->title,
            'description' => $ticket->description,
            'status'      => $ticket->status,
        ];

        Mail::send('emails.SendTicketUpdate', $data, function($message) use ($data) {
            $message->from(env('MAIL_FROM_ADDRESS'), 'Asad Mansuri');
            $message->subject($data['title'].' : '.$data['status']. ' Ticket');
            $message->to($data['email']);
        });
    }
}
