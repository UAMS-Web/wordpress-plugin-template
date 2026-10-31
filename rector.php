<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/includes',
        __DIR__.'/tests',
        __DIR__.'/scripts',
        __DIR__.'/uams-plugin-template.php',
        __DIR__.'/uninstall.php',
    ])
    ->withSkip([
        __DIR__.'/tests/Integration/vendor',
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        earlyReturn: true,
    )
    // The supported floor, not the development PHP.
    ->withPhpVersion(PhpVersion::PHP_82)
    ->withPhpSets(php82: true);
