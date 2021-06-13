<?php
namespace Modules\Peer\Tests\Feature;

use Modules\Peer\Tests\PeerTestCase;

class PeerTest extends PeerTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
