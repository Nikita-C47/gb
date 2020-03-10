<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Класс, представляющий изображение, прикрепленное к записи.
 * @package App\Models Модели приложения.
 *
 * @property int $id ID в БД.
 * @property int $entry_id ID записи, с которой связано изображение.
 * @property string $name Название файла изображения в хранилище.
 * @property string $original_name Оригинальное название файла.
 * @property string $extension Расширение файла.
 * @property string $link Ссылка на изображение в публичной части.
 * @property string $thumbnail_link Ссылка на миниатюру изображения в публичной части.
 * @property string $folder Папка, в которой хранятся файлы для записи.
 * @property string $file_name Полное название файла, хранящегося в хранилище.
 * @property string $file_path Полный путь к файлу в хранилище.
 * @property string $thumbnail_path Полный путь к миниатюре файла в хранилище.
 * @property Carbon $created_at Дата создания.
 * @property Carbon $updated_at Дата обновления.
 *
 * @property Entry $entry Связная модель записи, к которой добавлено изображение.
 */
class EntryImage extends Model
{
    /** @var array $fillable заполняемые поля. */
    protected $fillable = ['entry_id', 'name', 'original_name', 'extension'];

    /**
     * Связь с таблицей записей.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo('App\Models\Entry');
    }

    /**
     * Возвращает атрибут с папкой, в которой содержатся изображения.
     *
     * @return string
     */
    public function getFolderAttribute()
    {
        return "images/".$this->entry_id;
    }

    /**
     * Возвращает атрибут с названием файла (с расширением).
     *
     * @return string
     */
    public function getFileNameAttribute()
    {
        return $this->name.".".$this->extension;
    }

    /**
     * Возвращает атрибут пути к файлу.
     *
     * @return string
     */
    public function getFilePathAttribute()
    {
        return $this->folder."/".$this->file_name;
    }

    /**
     * Возвращает атрибут ссылки на изображение в публичной части.
     *
     * @return string
     */
    public function getLinkAttribute()
    {
        return $this->getLink($this->file_path);
    }

    /**
     * Возвращает атрибут пути к файлу миниатюры изображения.
     *
     * @return string
     */
    public function getThumbnailPathAttribute()
    {
        return $this->folder."/thumbnails/".$this->file_name;
    }

    /**
     * Возвращает атрибут ссылки на миниатюру изображения в публичной части.
     *
     * @return string
     */
    public function getThumbnailLinkAttribute()
    {
        return $this->getLink($this->thumbnail_path);
    }

    /**
     * Возвращает ссылку на файл в публичной части по пути к изображению.
     *
     * @param string $path путь к изображению.
     * @return string
     */
    private function getLink(string $path)
    {
        return config('app.url').Storage::url($path);
    }

    /**
     * Сохраняет файл в файловой системе.
     *
     * @param UploadedFile $file загруженный файл.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException исключение если файл изображения не найден.
     */
    public function saveInFileSystem(UploadedFile $file)
    {
        // Сохраняем файл
        $file->storeAs($this->folder, $this->file_name, 'public');
        // Генерируем миниатюру
        $this->makeThumbnail();
    }

    /**
     * Удаляет файл из файловой системы.
     */
    public function removeFromFileSystem()
    {
        // Удаляем файл и миниатюру
        Storage::disk('public')->delete([
            $this->file_path,
            $this->thumbnail_path
        ]);
    }

    /**
     * Генерирует миниатюру изображения.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException исключение если файл изображения не найден.
     */
    public function makeThumbnail()
    {
        // Получаем оригинальный файл
        $file = Storage::disk('public')->get($this->file_path);
        // Создаем изображение
        $image = imagecreatefromstring($file);
        // Масштабируем с шириной 200 пикселей и автоматической высотой
        $thumbnail = imagescale($image, 200);
        // Сохраняем миниатюру
        $this->saveThumbnail($thumbnail);
    }

    /**
     * Сохраняет миниатюру изображения в файл.
     *
     * @param resource $thumbnail сформированная миниатюра изображения.
     * @return bool статус сохранения.
     * @throws InvalidArgumentException исключение, если изображение имеет неверный формат.
     */
    private function saveThumbnail($thumbnail)
    {
        // Папка с миниатюрами изображений для записи
        $thumbnailsFolder = $this->folder.'/thumbnails';
        // Если папки нет - создаем ее
        if(!in_array($thumbnailsFolder, Storage::disk('public')->directories())) {
            Storage::disk('public')->makeDirectory($thumbnailsFolder);
        }
        // Получаем полный путь к файлу
        $storagePath = storage_path('app/public/'.$this->thumbnail_path);
        // Проверяем расширение файла и в зависимости от него сохраняем в нужный формат
        switch (Str::lower($this->extension)) {
            case 'jpeg':
            case 'jpg':
                return imagejpeg($thumbnail, $storagePath);
                break;
            case 'png':
                return imagepng($thumbnail, $storagePath);
                break;
            case 'gif':
                return imagegif($thumbnail, $storagePath);
                break;
            case 'bmp':
                return imagebmp($thumbnail, $storagePath);
                break;
            case 'webp':
                return imagewebp($thumbnail, $storagePath);
                break;
            default:
                // Если формат не распознан - выкидываем исключение
                throw new InvalidArgumentException('File "'.$this->file_name.'" is not valid jpg, png, bmp, gif or webp image.');
                break;
        }
    }
}
