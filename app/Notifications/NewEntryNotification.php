<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Класс, представляющий уведомление о новой записи в гостевой книге.
 * @package App\Notifications Уведомления приложения.
 */
class NewEntryNotification extends Notification implements ShouldQueue
{
    use Queueable;
    /** @var array $entry данные о записи. */
    private $entry;

    /**
     * Создает новый экземпляр класса.
     *
     * @param array $entry запись.
     */
    public function __construct(array $entry)
    {
        // Инициализируем поле
        $this->entry = $entry;
    }

    /**
     * Получает каналы доставки уведомления.
     *
     * @param mixed $notifiable уведомляемый объект.
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Получает представление уведомления в виде письма.
     *
     * @param mixed $notifiable уведомляемый объект.
     * @return \Illuminate\Notifications\Messages\MailMessage объект сообщения для отправки.
     */
    public function toMail($notifiable)
    {
        // Собираем сообщение
        return (new MailMessage)
                    ->subject('Новая запись в гостевой книге')
                    ->greeting('Здравствуйте! В гостевой книге появилась новая запись.')
                    ->line('Автор: '.$this->entry['author'])
                    ->line('Текст: '.$this->entry['content'])
                    ->action('Перейти к записям', route('home'))
                    ->line('Данное сообщение сгенерировано автоматически. Отвечать на него не нужно.');
    }

    /**
     * Получает представление уведомления в виде массива.
     *
     * @param mixed $notifiable уведомляемый объект.
     * @return array массив.
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
