<?php declare(strict_types=1);

namespace Tests;

use Matmper\PhpToon;
use PHPUnit\Framework\Attributes\Test;

class DecodeTest extends TestCase
{
    #[Test]
    public function test_php_toon_decode_assoc_success(): void
    {
        $toon = "users[2]{id,name,age}:
            1,User 1,20
            2,User 2,30";

        $decode = PhpToon::decode($toon, true);

        $this->assertIsArray($decode);
    }
}
