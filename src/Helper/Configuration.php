<?php
declare(strict_types=1);

namespace GhRelease\Helper;

/**
 * @author  david.pauli
 * @package GhRelease\Helper
 * @since   17.08.2018
 */
trait Configuration
{
    private $pathToConfig = __DIR__ . '/../../configuration.json';

    public function configure(): void
    {
        $classPath = $this->buildClassPathArray();
        $configurationArray = json_decode(file_get_contents($this->pathToConfig), true);
        foreach ($classPath as $entry) {
            $configurationArray = $configurationArray[strtolower($entry)] ?? [];
        }
        $this->loadConfiguration($configurationArray);
    }

    /**
     * Returns the full class name (with namespace path) as array.
     *
     * @return string[]
     */
    private function buildClassPathArray(): array
    {
        return explode('\\', __CLASS__);
    }

    /**
     * Writes the configuration.
     *
     * @param array $configuration
     */
    private function loadConfiguration(array $configuration): void
    {
        foreach ($configuration as $variable => $value) {
            if (property_exists($this, $variable)) {
                $this->$variable = $value;
            }
        }
    }
}
