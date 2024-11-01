<?php

declare (strict_types=1);
namespace UltimateYoutubeFeedScoped\Bamarni\Composer\Bin\ApplicationFactory;

use UltimateYoutubeFeedScoped\Composer\Console\Application;
interface NamespaceApplicationFactory
{
    public function create(Application $existingApplication) : Application;
}
