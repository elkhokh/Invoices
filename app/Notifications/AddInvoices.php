<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoices extends Notification
{
    use Queueable;
    // protected $invoice ;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice)
    {
    // $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage);
        //     // ->subject('اضافة فاتورة جديدة')
        //     // ->line('اضافة فاتورة جديدة !')
        //     // ->action(' عرض الفاتورة', url('http://127.0.0.1:8000/'))
        //     // ->line('شكرا ');
        // ->subject('إضافة فاتورة جديدة: ' . $this->invoice->invoice_number)
        // ->greeting('مرحباً ' . $notifiable->name)
        // ->line('تم إضافة فاتورة جديدة برقم: ' . $this->invoice->invoice_number)
        // ->line('المبلغ الإجمالي: ' . $this->invoice->total)
        // ->line('تاريخ الفاتورة: ' . $this->invoice->invoice_date)
        // ->action('عرض الفاتورة', route('invoices.show', $this->invoice->id))
        // ->line('شكراً لاستخدامك نظامنا.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
