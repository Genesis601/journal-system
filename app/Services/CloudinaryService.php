<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }

    public function uploadFile(string $filePath, string $folder = 'journal-system'): array
    {
        $result = $this->cloudinary->uploadApi()->upload($filePath, [
            'folder'        => $folder,
            'resource_type' => 'raw',
        ]);

        return [
            'secure_url' => $result['secure_url'],
            'public_id'  => $result['public_id'],
        ];
    }

    public function uploadImage(string $filePath, string $folder = 'journal-system'): array
    {
        $result = $this->cloudinary->uploadApi()->upload($filePath, [
            'folder'        => $folder,
            'resource_type' => 'image',
        ]);

        return [
            'secure_url' => $result['secure_url'],
            'public_id'  => $result['public_id'],
        ];
    }

    public function deleteFile(string $publicId, string $resourceType = 'raw'): void
    {
        try {
            $this->cloudinary->uploadApi()->destroy($publicId, [
                'resource_type' => $resourceType,
            ]);
        } catch (\Exception $e) {
            Log::error('Cloudinary delete failed: ' . $e->getMessage());
        }
    }
}