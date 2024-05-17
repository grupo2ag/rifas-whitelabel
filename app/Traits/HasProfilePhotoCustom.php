<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Features;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

trait HasProfilePhotoCustom
{
    public function updateProfilePhoto(UploadedFile $photo, $storagePath = 'profile-photos')
    {
        $name = (string) Str::uuid();
        $webp = (string) Image::make($photo->get())->encode('webp', 75);
        $path = config('filesystems.disks.s3.path').'/images/'.auth()->user()->id.'/'.$storagePath.'/'.$name.'.webp';
        Storage::disk($this->profilePhotoDisk())->put($path, $webp);

        tap($this->profile_photo_path, function ($previous) use ($photo, $path, $webp) {
            $this->forceFill([
                'profile_photo_path' => $path
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    public function getTemporaryProfilePhotoUrl()
    {
        if ($this->profile_photo_path) {
            return Storage::disk($this->profilePhotoDisk())->temporaryUrl(
                $this->profile_photo_path,
                now()->addHours(1) // La URL expirará en una hora
            );
        } else {
            return $this->defaultProfilePhotoUrl();
        }
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        if (! Features::managesProfilePhotos()) {
            return;
        }

        if (is_null($this->profile_photo_path)) {
            return;
        }

        Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path);

        $this->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->profile_photo_path
                //? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
                ? Storage::disk($this->profilePhotoDisk())->temporaryUrl($this->profile_photo_path, now()->addMinutes(5))
                : $this->defaultProfilePhotoUrl();
        });
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function profilePhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }
}
