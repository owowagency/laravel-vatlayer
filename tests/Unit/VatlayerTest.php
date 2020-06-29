<?php

namespace Tests\Unit;

use Tests\TestCase;
use Vatlayer\Vatlayer;
use Vatlayer\Exceptions\RequestFailed;

class VatlayerTest extends TestCase
{
    /** @test */
    public function it_should_fail_when_no_api_key_is_provided()
    {
        $vatlayer = app(Vatlayer::class);

        $this->expectExceptionObject(new RequestFailed(101));

        $vatlayer->validate('NL123456789B01');
    }
}
