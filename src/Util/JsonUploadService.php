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
     * list of entities to be check for integrity
     */
    const JSON_MAP_ENTITIES = array('article', 'author', 'image', 'chapter');


    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityManagerInterface
     */
    private $integrityCheckService;


    /**
     * JsonUploadService constructor.
     *
     * @param LoggerInterface        $logger
     * @param EntityManagerInterface $entityManager
     * @param IntegrityCheckService  $integrityCheckService
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager, IntegrityCheckService $integrityCheckService)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->integrityCheckService = $integrityCheckService;
    }


    /**
     * Insert data into database
     *
     * @param $data
     *
     * @return mixed|string
     */
    public function insertIntoDb($data)
    {
        try {

            //filter input, XSS attack
            $sanitizedData = $this->sanitizeJsonInput($data);

            //get data from $sanitizedData
            $author = $sanitizedData['author'];
            $image = $sanitizedData['image'];
            $chapter = $sanitizedData['chapters'];

            $entityArr = [];
            foreach (self::JSON_MAP_ENTITIES as $entity) {
                switch ($entity) {
                    case 'article':
                        $entityArr = $sanitizedData;
                        break;
                    case 'author':
                        $entityArr = $author;
                        break;
                    case 'image':
                        $entityArr = $image;
                        break;
                    case 'chapter':
                        $entityArr = $chapter;
                        break;
                }

                if (!$this->integrityCheckService->integrityCheck($entity, $entityArr)) {
                    return sprintf('Hochgeladen json hat kein (%s) Entity oder/und unvollständige Tabellenspalten, und könnte nicht in der Datenbank gemapped werden', $entity);
                }
            }

            //init entities
            $article = new Articles();
            $authorEntity = new Authors();
            $imageEntity = new Images();

            //set Author info
            $authorEntity->setFirstName($author['firstName']);
            $authorEntity->setLastName($author['lastName']);

            //set Image info
            $imageEntity->setHeight($image['height']);
            $imageEntity->setWidth($image['width']);
            $imageEntity->setText($image['text']);
            $imageEntity->setUrl($image['url']);
            $imageEntity->setSource($image['source']);

            //set Article info
            $article->setUrlId($sanitizedData['urlId']);
            $article->setUrlSlug(preg_replace('/\s+/', '', $sanitizedData['urlSlug']));
            $article->setHeadline($sanitizedData['headline']);
            $article->setSubtitle($sanitizedData['subtitle']);
            $article->setIntroduction($sanitizedData['introduction']);
            $article->setDisplayDateTimestamp((int)$sanitizedData['displayDate']['timestamp']);
            $article->setAuthor($authorEntity);
            $article->setImage($imageEntity);

            $imageEntityChapter = new Images();
            //loop through chapter array and assign values
            foreach ($chapter as $value) {
                $chapterEntity = new Chapters();
                $chapterEntity->setOrder($value['order']);
                $chapterEntity->setHeadline($value['headline']);
                $chapterEntity->setText($value['text']);
                //set chapter's image info
                if (!empty((array)$value['image'])) {
                    $imageEntityChapter->setHeight($value['image']['height']);
                    $imageEntityChapter->setWidth($value['image']['width']);
                    $imageEntityChapter->setText($value['image']['text']);
                    $imageEntityChapter->setUrl($value['image']['url']);
                    $imageEntityChapter->setSource($value['image']['source']);
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

    /**
     * Validate and remove html/script tags from from data
     *
     * @param $data
     *
     * @return mixed
     */
    private function sanitizeJsonInput($data)
    {
        //convert json to array
        $data = json_decode($data, true);

        //build filter structure
        $args = array(
            'id' => FILTER_VALIDATE_INT,
            'urlId' => FILTER_VALIDATE_INT,
            'urlSlug' => FILTER_SANITIZE_STRING,
            'headline' => FILTER_SANITIZE_STRING,
            'subtitle' => FILTER_SANITIZE_STRING,
            'introduction' => FILTER_SANITIZE_STRING,
            'displayDate' => array(
                'filter' => FILTER_VALIDATE_INT,
                'flags' => FILTER_FORCE_ARRAY,
            ),
            'author' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_FORCE_ARRAY,
            ),
            'image' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_FORCE_ARRAY,
            ),
            'chapters' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_FORCE_ARRAY,
            )

        );


        return filter_var_array($data, $args);
    }

}