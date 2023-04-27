<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Street\App\model\User;

class UserTest extends TestCase
{
    #[PHPUnit\Framework\Attributes\Test]
    public function testName()
    {
        $user = new User();
        $user->setInitial('greg');
        $this->assertSame('greg', $user->getInitial());
    }
}
