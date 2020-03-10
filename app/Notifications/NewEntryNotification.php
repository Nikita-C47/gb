<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEntryNotification extends Notification implements ShouldQueue
{
    use Queueable;


    private $entry;

    /**
     * Create a new notification instance.
     *
     * @param array $entry
     */
    public function __construct(array $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Новая запись в гостевой книге')
                    ->greeting('Здравствуйте! В гостевой книге появилась новая запись.')
                    ->line('Автор: '.$this->entry['author'])
                    ->line('Текст: '.$this->entry['content'])
                    ->action('Перейти к записям', route('home'))
                    ->line('Данное сообщение сгенерировано автоматически. Отвечать на него не нужно.');
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
