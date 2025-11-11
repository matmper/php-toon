<?php declare(strict_types=1);

namespace Tests;

use Matmper\PhpToon;
use PHPUnit\Framework\Attributes\Test;

class EncodeTest extends TestCase
{
    #[Test]
    public function test_php_toon_encode_success(): void
    {
        $array = (object) [
            ['id' => 1, 'name' => 'User 1', 'age' => 20],
            ['id' => 2, 'name' => 'User 2', 'age' => 30],
        ];

        $encode = PhpToon::encode($array, 'users');

        $this->assertIsString($encode);
        $this->assertNotEmpty($encode);
        $this->assertEquals($encode, "users[2]{id,name,age}:\n    1,User 1,20\n    2,User 2,30");
    }
}
