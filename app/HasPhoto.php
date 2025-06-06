<?php

namespace App;

use Illuminate\Support\Facades\Storage;

/**
 * @method save()
 */
trait HasPhoto
{
    protected ?string $photo = null;

    public function uploadPhoto($file, $folder = 'photos'): static
    {
        if ($this->photo) {
            Storage::delete($this->photo);
        }

        $path = $file->store($folder, 'public');
        $this->photo = $path;
        $this->save();

        return $this;
    }

    public function deletePhoto(): static
    {
        if ($this->photo) {
            Storage::delete($this->photo);
            $this->photo = null;
            $this->save();
        }

        return $this;
    }
}
