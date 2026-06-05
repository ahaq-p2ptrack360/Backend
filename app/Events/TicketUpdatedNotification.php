<?php

namespace App\Events;

use App\Models\UserNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TicketUpdatedNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $ticketData;
    public $companyId;

    public function __construct($ticketData, $userName, $changedFields = [], $companyId = null)
    {
        $this->ticketData = $ticketData;
        $this->companyId = $companyId;
        
        Log::info('TicketUpdatedNotification: Started', [
            'ticket_id' => $ticketData->id,
            'company_id' => $companyId,
            'user_name' => $userName,
            'changed_fields' => $changedFields
        ]);
        
        // Create message
        $message = "{$userName} has updated a ticket";
        if (!empty($changedFields)) {
            $fields = implode(', ', $changedFields);
            $message .= " (Updated: {$fields})";
        }
        
        // Create notification in database
        $this->notification = UserNotification::create([
            'user_id' => null,
            'company_id' => $companyId,
            'type' => 'ticket_updated',
            'title' => 'Ticket Updated',
            'message' => $message,
            'data' => [
                'ticket_id' => $ticketData->id,
                'user_name' => $userName,
                'ticket_title' => $ticketData->title ?? 'No title',
                'changed_fields' => $changedFields,
                'company_id' => $companyId
            ],
            'ticket_id' => $ticketData->id,
            'is_read' => false,
        ]);
        
        Log::info('TicketUpdatedNotification: Notification saved', [
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
        return 'ticket.updated';
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
        
        
        return $data;
    }
}