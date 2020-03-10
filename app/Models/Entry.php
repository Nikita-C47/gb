<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс, представляющий модель записи в гостевой книге.
 * @package App\Models Модели приложения.
 *
 * @property int $id ID записи в БД;
 * @property int|null $user_id Пользователь, добавивший запись.
 * @property string $author Имя автора, оставившего запись.
 * @property string $content Текст записи.
 * @property Carbon $created_at Дата создания.
 * @property Carbon $updated_at Дата обновления.
 *
 * @property \App\User|null $user Связная модель пользователя, добавившего запись.
 * @property Collection $images Связная модель списка прикрепленных к записи изображений.
 */
class Entry extends Model
{
    /** @var array $fillable заполняемые поля. */
    protected $fillable = ['user_id', 'author', 'content'];

    /**
     * Связь с таблицей пользователей.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Связь с таблицей изображений.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\EntryImage');
    }
}
