<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    private const DISK = 'public';

    /**
     * Сохранить файл в указанную директорию.
     * Возвращает путь к файлу.
     */
    public function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, self::DISK);
    }

    /**
     * Удалить файл из хранилища если он существует.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }
    }

    /**
     * Заменить старый файл новым.
     * Удаляет старый, сохраняет новый, возвращает новый путь.
     */
    public function replace(?string $oldPath, UploadedFile $newFile, string $directory): string
    {
        $this->delete($oldPath);

        return $this->store($newFile, $directory);
    }

    /**
     * Получить публичный URL по пути.
     */
    public function url(string $path): string
    {
        return asset('storage/' . $path);
    }
}
