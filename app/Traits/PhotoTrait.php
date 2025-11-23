<?php

namespace App\Traits;

use Buglinjo\LaravelWebp\Exceptions\CwebpShellExecutionFailed;
use Buglinjo\LaravelWebp\Exceptions\DriverIsNotSupportedException;
use Buglinjo\LaravelWebp\Exceptions\ImageMimeNotSupportedException;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Support\Facades\File;

trait PhotoTrait
{
    /**
     * @throws CwebpShellExecutionFailed
     * @throws ImageMimeNotSupportedException
     * @throws DriverIsNotSupportedException
     */
    function saveImage($photo, $folder, $type = 'image', $quality_ratio = 70): string
    {
        $storagePath = storage_path('app/public/' . $folder);

        File::ensureDirectoryExists($storagePath);

        if ($type == 'image' || $type === null) {
            try {
                $webp = Webp::make($photo);
                $file_name = $folder . '/' . rand(1, 9999) . time() . '.webp';
                $webp->save($storagePath . '/' . basename($file_name), $quality_ratio);
                $FileName = basename($file_name);
            } catch (\Exception $e) {
                $file_extension = $photo->getClientOriginalExtension();
                $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $FileName = $originalName . '_' . time() . '.' . $file_extension;
                $photo->move($storagePath, basename($FileName));
            }
        } else {
            $file_extension = $photo->getClientOriginalExtension();
            $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $FileName = $originalName . '_' . time() . '.' . $file_extension;
            $photo->move($storagePath, basename($FileName));
        }

        return 'storage/' . $folder . '/' . $FileName;
    }
}


















































// namespace App\Traits;

// use Buglinjo\LaravelWebp\Exceptions\CwebpShellExecutionFailed;
// use Buglinjo\LaravelWebp\Exceptions\DriverIsNotSupportedException;
// use Buglinjo\LaravelWebp\Exceptions\ImageMimeNotSupportedException;
// use Buglinjo\LaravelWebp\Webp;
// use Illuminate\Support\Facades\File;

// trait PhotoTrait
// {
//     /**
//      * @throws CwebpShellExecutionFailed
//      * @throws ImageMimeNotSupportedException
//      * @throws DriverIsNotSupportedException
//      */
//     function saveImage($photo, $folder, $type = 'image', $quality_ratio = 70): string
//     {


//         $storagePath = storage_path('app/public/' . $folder);

//         File::ensureDirectoryExists($storagePath);

//         if ($type == 'image' || $type === null) {
//             $webp = Webp::make($photo);
//             $file_name = $folder . '/' . rand(1, 9999) . time() . '.webp';

//             $webp->save($storagePath . '/' . basename($file_name), $quality_ratio);
//         } else {
//             $file_extension = $photo->getClientOriginalExtension();
//             $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
//             $FileName = $originalName . '_' . time() . '.' . $file_extension;

//             $photo->move($storagePath, basename($FileName));
//         }

//         return 'storage/' . $FileName;
//     }
// }
