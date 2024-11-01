<?php

declare (strict_types=1);
namespace UltimateYoutubeFeedScoped\Bamarni\Composer\Bin;

use UltimateYoutubeFeedScoped\Bamarni\Composer\Bin\Command\BinCommand;
use UltimateYoutubeFeedScoped\Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
/**
 * @final Will be final in 2.x.
 */
class CommandProvider implements CommandProviderCapability
{
    public function getCommands() : array
    {
        return [new BinCommand()];
    }
}
