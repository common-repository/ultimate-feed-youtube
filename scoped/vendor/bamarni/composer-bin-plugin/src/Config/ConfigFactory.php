<?php

declare (strict_types=1);
namespace UltimateYoutubeFeedScoped\Bamarni\Composer\Bin\Config;

use UltimateYoutubeFeedScoped\Composer\Config as ComposerConfig;
use UltimateYoutubeFeedScoped\Composer\Factory;
use UltimateYoutubeFeedScoped\Composer\Json\JsonFile;
use UltimateYoutubeFeedScoped\Composer\Json\JsonValidationException;
use UltimateYoutubeFeedScoped\Seld\JsonLint\ParsingException;
final class ConfigFactory
{
    /**
     * @throws JsonValidationException
     * @throws ParsingException
     */
    public static function createConfig() : ComposerConfig
    {
        $config = Factory::createConfig();
        $file = new JsonFile(Factory::getComposerFile());
        if (!$file->exists()) {
            return $config;
        }
        $file->validateSchema(JsonFile::LAX_SCHEMA);
        $config->merge($file->read());
        return $config;
    }
    private function __construct()
    {
    }
}
