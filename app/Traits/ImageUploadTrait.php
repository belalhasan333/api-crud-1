<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    public function uploadImage($image)
    {
        // Clean image name
        $imageName = Str::slug(
            pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

        // Upload inside blogs folder
        Storage::disk('public')->put('blogs/' . $imageName, file_get_contents($image));

        return $imageName;
    }

    public function deleteImage($imageName)
    {
        if ($imageName && Storage::disk('public')->exists('blogs/' . $imageName)) {
            Storage::disk('public')->delete('blogs/' . $imageName);
        }
    }
}
