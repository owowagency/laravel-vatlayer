<?php

namespace Tests\Unit;

use Tests\TestCase;
use Vatlayer\Vatlayer;

class ValidateVatNumberTest extends TestCase
{
    /** @test */
    public function it_should_return_true_on_valid_vat_number()
    {
        $vatlayer = $this->basicMock()
            ->andReturn(json_decode('{"valid":true,"format_valid":true,"query":"NL123456789B01","country_code":"NL","vat_number":"123456789B01","company_name":"OWOW PROJECTS B.V.","company_address":" FUUTLAAN 00014 UNIT E 5613AB EINDHOVEN "}', true))
            ->getMock();

        $this->assertTrue($vatlayer->isValidVatNumber('NL123456789B01'));
    }

    /** @test */
    public function it_should_return_false_on_invalid_vat_number()
    {
        $vatlayer = $this->basicMock()
            ->andReturn(json_decode('{"valid":false,"format_valid":true,"query":"NL123456789B01","country_code":"NL","vat_number":"123456789B01","company_name":"","company_address":""}', true))
            ->getMock();

        $this->assertFalse($vatlayer->isValidVatNumber('NL123456789B01'));
    }

    /** @test */
    public function it_should_return_false_on_invalid_vat_number_format()
    {
        $vatlayer = $this->basicMock()
            ->andReturn(json_decode('{"valid":false,"format_valid":false,"query":"NL12345678B01","country_code":"","vat_number":"","company_name":"","company_address":""}', true))
            ->getMock();

        $this->assertFalse($vatlayer->isValidVatNumber('NL123456789B01'));
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
