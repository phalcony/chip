<?php


namespace App\Tests;


use App\Util\ValidationService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ValidatorServiceTest
 * @package App\Tests
 */
class ValidatorServiceTest extends TestCase
{

    // TODO: unit test to be developed for each function of this service as well as controllers but to due lack of time i created a few

    /**
     * Test json extension validation functionality (Success Scenario)
     */
    public function testValidationJsonExtentionSuccess(): void
    {

        // Use MockBuilder to get ride of constructor dependencies
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $file = new UploadedFile('tests/asset/text.json', 'text.json', 'application/json', 123);

        $validationService = new ValidationService($logger);
        $status = $validationService->validate($file);

        $this->assertTrue($status);
    }

    /**
     * Test json extension validation functionality (Failed Scenario)
     */
    public function testValidationJsonExtentionFailed(): void
    {

        // Use MockBuilder to get ride of constructor dependencies
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $file = new UploadedFile('tests/asset/test.png', 'test.png', 'image/jpeg', 123);

        $validationService = new ValidationService($logger);
        $status = $validationService->validate($file);

        $this->assertEquals('Falscher Dateityp, bitte laden Sie eine JSON-Datei hoch', $status);
    }


    /**
     * Test json validity functionality (Failed Scenario)
     */
    public function testValidationJsonFailed(): void
    {

        // Use MockBuilder to get ride of constructor dependencies
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $file = new UploadedFile('tests/asset/failed.json', 'text.json', 'application/json', 123);

        $validationService = new ValidationService($logger);
        $status = $validationService->validate($file);

        $this->assertEquals('Syntaxfehler, fehlerhaftes JSON', $status);
    }


}