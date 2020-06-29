<?php

namespace Tests\Unit;

use Tests\TestCase;
use Vatlayer\Vatlayer;
use Vatlayer\Exceptions\RequestFailed;

class ValidateTest extends TestCase
{
    /** @test */
    public function it_should_return_a_validate_response()
    {
        $vatlayer = $this->basicMock()
            ->andReturn(json_decode('{"valid":true,"format_valid":true,"query":"NL123456789B01","country_code":"NL","vat_number":"123456789B01","company_name":"OWOW PROJECTS B.V.","company_address":" FUUTLAAN 00014 UNIT E 5613AB EINDHOVEN "}', true))
            ->getMock();

        $response = $vatlayer->validate('NL123456789B01');

        $this->assertTrue($response['valid']);
        $this->assertTrue($response['format_valid']);
    }

    /** @test */
    public function it_shouldnt_find_an_invalid_vat_number()
    {
        $vatlayer = $this->basicMock()
            ->andReturn(json_decode('{"valid":false,"format_valid":true,"query":"NL123456789B01","country_code":"NL","vat_number":"123456789B01","company_name":"","company_address":""}', true))
            ->getMock();

        $response = $vatlayer->validate('NL123456789B01');

        $this->assertFalse($response['valid']);
        $this->assertTrue($response['format_valid']);
    }

    /** @test */
    public function it_shouldnt_find_an_invalid_vat_number_format()
    {
        $vatlayer = $this->basicMock()
            ->andReturn(json_decode('{"valid":false,"format_valid":false,"query":"NL12345678B01","country_code":"","vat_number":"","company_name":"","company_address":""}', true))
            ->getMock();

        $response = $vatlayer->validate('NL123456789B01');

        $this->assertFalse($response['valid']);
        $this->assertFalse($response['format_valid']);
    }

    /**
     * Get the basic mock instance.
     *
     * @return \Mockery\Expectation|\Mockery\ExpectationInterface|\Mockery\HigherOrderMessage
     */
    protected function basicMock()
    {
        return \Mockery::mock(Vatlayer::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial()
            ->shouldReceive('execute');
    }
}
