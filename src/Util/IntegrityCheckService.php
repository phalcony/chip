<?php


namespace App\Util;


/**
 * Class IntegrityCheckService
 * @package App\Util
 */
class IntegrityCheckService
{

    /**
     * @var array
     */
    private static $articleRequiredFields = ['urlId', 'urlSlug', 'headline', 'subtitle', 'introduction', 'displayDate'];
    /**
     * @var array
     */
    private static $authorRequiredFields = ['firstName', 'lastName'];
    /**
     * @var array
     */
    private static $imageRequiredFields = ['height', 'width', 'text', 'url', 'source'];
    /**
     * @var array
     */
    private static $chapterRequiredFields = ['order', 'headline', 'text', 'image'];

    /**
     * @param string $entity
     * @param array  $entityArr
     *
     * @return bool
     */
    public function integrityCheck($entity, $entityArr): bool
    {
        if (empty($entityArr)) {
            return false;
        }

        $requiredFields = [];
        switch ($entity) {
            case 'article':
                $requiredFields = self::$articleRequiredFields;
                break;
            case 'author':
                $requiredFields = self::$authorRequiredFields;
                break;
            case 'image':
                $requiredFields = self::$imageRequiredFields;
                break;
            case 'chapter':
                $requiredFields = self::$chapterRequiredFields;
                break;
        }

        foreach ($requiredFields as $value) {
            if ($entity === 'chapter') {
                foreach ($entityArr as $subArr) {
                    if (!array_key_exists($value, $subArr) && !in_array($value, $subArr, false)) {
                        return false;
                    }
                }

            } else {
                if (!array_key_exists($value, $entityArr) && !in_array($value, $entityArr, false)) {
                    return false;
                }
            }


        }

        return true;
    }
}