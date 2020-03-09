<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс, представляющий модель записи в гостевой книге.
 * @package App\Models Модели приложения.
 *
 * @property int $id ID записи в БД;
 * @property string $author Имя автора, оставившего запись.
 * @property string $content Текст записи.
 * @property Carbon $created_at Дата создания.
 * @property Carbon $updated_at Дата обновления.
 */
class Entry extends Model
{
    /** @var array $fillable заполняемые поля. */
    protected $fillable = ['author', 'content'];
}
