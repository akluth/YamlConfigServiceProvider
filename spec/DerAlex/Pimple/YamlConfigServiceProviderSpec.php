<?php

namespace spec\DerAlex\Pimple;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YamlConfigServiceProviderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(__DIR__ . '/../../Fixtures/config.yml');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DerAlex\Pimple\YamlConfigServiceProvider');
    }
}
