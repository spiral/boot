<?php

declare(strict_types=1);

namespace Spiral\Boot\Environment;

use Spiral\Boot\EnvironmentInterface;
use Spiral\Boot\Injector\ProvideFrom;
use Spiral\Boot\Injector\InjectableEnumInterface;

#[ProvideFrom(method: 'detect')]
enum AppEnvironment: string implements InjectableEnumInterface
{
    case Production = 'prod';
    case Stage = 'stage';
    case Testing = 'testing';
    case Local = 'local';

    public static function detect(EnvironmentInterface $environment): self
    {
        $value = $environment->get('APP_ENV');

        // Aliases
        $value = match ($value) {
            'production' => self::Production->value,
            'test' => self::Testing->value,
            default => $value,
        };

        return \is_string($value)
            ? (self::tryFrom($value) ?? self::Local)
            : self::Local;
    }

    public function isProduction(): bool
    {
        return $this === self::Production;
    }

    public function isTesting(): bool
    {
        return $this === self::Testing;
    }

    public function isLocal(): bool
    {
        return $this === self::Local;
    }

    public function isStage(): bool
    {
        return $this === self::Stage;
    }
}
