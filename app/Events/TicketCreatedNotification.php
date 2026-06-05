<?php

namespace App\Events;

use App\Models\UserNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TicketCreatedNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $ticketData;
    public $companyId;

    public function __construct($ticketData, $userName, $companyId = null)
    {
        $this->ticketData = $ticketData;
        $this->companyId = $companyId;
        
        // Debug log
        Log::info('TicketCreatedNotification: Started', [
            'ticket_id' => $ticketData->id,
            'company_id' => $companyId,
            'user_name' => $userName
        ]);
        
        // Get assigned user ID
        $assignedTo = $ticketData->assigned_to ?? null;
        
        // Create notification in database
        $this->notification = UserNotification::create([
            'user_id' => $assignedTo,
            'company_id' => $companyId,
            'type' => 'ticket_created',
            'title' => 'New Ticket Created',
            'message' => "{$userName} has created a new ticket: {$ticketData->title}",
            'data' => [
                'ticket_id' => $ticketData->id,
                'user_name' => $userName,
                'ticket_title' => $ticketData->title ?? 'No title',
                'company_id' => $companyId
            ],
            'ticket_id' => $ticketData->id,
            'is_read' => false,
        ]);
        
        Log::info('TicketCreatedNotification: Notification saved', [
            'notification_id' => $this->notification->id,
            'company_id' => $companyId
        ]);
    }

    public function broadcastOn()
    {
        // Simple channel for testing - sabko notification milega
        return new Channel('tickets');
    }

    public function broadcastAs()
    {
        return 'ticket.created';
    }

    public function broadcastWith()
    {
        $data = [
            'notification_id' => $this->notification->id,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'ticket_id' => $this->ticketData->id,
            'company_id' => $this->companyId,
            'data' => $this->notification->data,
            'created_at' => $this->notification->created_at->diffForHumans()
        ];
        
        Log::info('TicketCreatedNotification: Broadcasting', $data);
        
        return $data;
    }
}