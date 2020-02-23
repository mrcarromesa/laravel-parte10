<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class NewDev extends Notification implements ShouldQueue
{
    use Queueable;

    private $dev = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dev)
    {
        $this->dev = $dev;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }


    public function toSlack($notifiable)
    {
        $url = url('/invoices/' . 'a');
        return (new SlackMessage)
            ->image('https://laravel.com/img/favicon/favicon.ico')
            ->success()
            ->content('One of your invoices has been paid!')
            ->attachment(function ($attachment) use ($url) {
                $attachment->title('Invoice 1322', $url)
                    ->fields([
                        'Title' => 'Server Expenses2',
                        'Amount' => '$1,234',
                        'Via' => 'American Express2',
                        'Was Overdue' => ':-1:',
                    ]);
            });
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
