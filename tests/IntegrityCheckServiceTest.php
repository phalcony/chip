<?php

namespace App\Tests\Services;


use App\Util\IntegrityCheckService;
use PHPUnit\Framework\TestCase;

/**
 * Class IntegrityCheckServiceTest
 * @package App\Tests\Services
 */
class IntegrityCheckServiceTest extends TestCase
{

    // TODO: unit test to be developed for each function of this service as well as controllers but to due lack of time i created a few

    /**
     * Test integrity-check functionality (success scenario empty array)
     */
    public function testIntegrityCheckSuccessEmptyArr(): void
    {
        $integrityCheckService = new IntegrityCheckService();

        $entityArr = [];
        $entity = 'author';

        $status = $integrityCheckService->integrityCheck($entity, $entityArr);
        $this->assertFalse($status);
    }

    /**
     * Test integrity-check  functionality (success scenario)
     */
    public function testIntegrityCheckSuccess(): void
    {
        $integrityCheckService = new IntegrityCheckService();

        $entityArr = ['firstName', 'lastName'];
        $entity = 'author';

        $status = $integrityCheckService->integrityCheck($entity, $entityArr);
        $this->assertTrue($status);
    }

    /**
     * Test integrity-check functionality (Failure scenario)
     */
    public function testIntegrityCheckFails(): void
    {
        $integrityCheckService = new IntegrityCheckService();
        $entityArr = ['id', 'someOtherField'];
        $entity = 'author';

        $status = $integrityCheckService->integrityCheck($entity, $entityArr);
        $this->assertFalse($status);
    }
}