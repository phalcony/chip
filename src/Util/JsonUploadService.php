<?php


namespace App\Util;


use App\Entity\Articles;
use App\Entity\Authors;
use App\Entity\Chapters;
use App\Entity\Images;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class JsonUploadService
 * @package App\Util
 */
class JsonUploadService
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * JsonUploadService constructor.
     *
     * @param LoggerInterface        $logger
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }


    /**
     * @param $data
     *
     * @return mixed|string
     */
    public function insertIntoDb($data)
    {
        try {

            //convert json to Object
            $dataObj = json_decode($data);

            //get entities data from dataObject
            $author = $dataObj->author;
            $image = $dataObj->image;
            $chapter = $dataObj->chapters;

            //init entities
            $article = new Articles();
            $authorEntity = new Authors();
            $imageEntity = new Images();

            //set Author info
            $authorEntity->setFirstName($author->firstName);
            $authorEntity->setLastName($author->lastName);

            //set Image info
            $imageEntity->setHeight($image->height);
            $imageEntity->setWidth($image->width);
            $imageEntity->setText($image->text);
            $imageEntity->setUrl($image->url);
            $imageEntity->setSource($image->source);

            //set Article info
            $article->setUrlId($dataObj->urlId);
            $article->setUrlSlug($dataObj->urlSlug);
            $article->setHeadline($dataObj->headline);
            $article->setSubtitle($dataObj->subtitle);
            $article->setIntroduction($dataObj->introduction);
            $article->setDisplayDateTimestamp((int)$dataObj->displayDate->timestamp);
            $article->setAuthor($authorEntity);
            $article->setImage($imageEntity);

            $imageEntityChapter = new Images();
            //loop through chapter array and assign values
            foreach ($chapter as $value) {
                $chapterEntity = new Chapters();
                $chapterEntity->setOrder($value->order);
                $chapterEntity->setHeadline($value->headline);
                $chapterEntity->setText($value->text);
                //set chapter's image info
                if (!empty((array)$value->image)) {
                    $imageEntityChapter->setHeight($value->image->height);
                    $imageEntityChapter->setWidth($value->image->width);
                    $imageEntityChapter->setText($value->image->text);
                    $imageEntityChapter->setUrl($value->image->url);
                    $imageEntityChapter->setSource($value->image->source);
                    $chapterEntity->setImage($imageEntityChapter);

                }
                //set article info
                $chapterEntity->setArticles($article);
                $this->entityManager->persist($chapterEntity);
            }

            $this->entityManager->flush();

            return true;

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return $e->getMessage();
        }

    }
}