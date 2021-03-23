<?php

namespace App\Services\Google;

use Google_Service_Drive_DriveFile;
use ReflectionProperty;

final class GoogleDriveAdapter extends \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter
{
    public function getFetchFieldsList(): string
    {
        $fetchFieldsList = new ReflectionProperty(parent::class, 'fetchfieldsList');
        $fetchFieldsList->setAccessible(true);

        return $fetchFieldsList->getValue($this);
    }

    // Chuyển từ access modifier protected sang public
    public function normaliseObject(Google_Service_Drive_DriveFile $object, $dirname): array
    {
        $result = parent::normaliseObject($object, $dirname);

        $result['basename'] = pathinfo($object->getName(), PATHINFO_BASENAME);

        return $result;
    }
}
