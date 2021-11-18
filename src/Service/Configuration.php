<?php

namespace App\Service;

use App\Repository\ConfigurationRepository;

class Configuration
{
    /**
     * @var ConfigurationRepository
     */
    private $configuration;

    /**
     * Configuration constructor.
     * @param ConfigurationRepository $configuration
     */
    public function __construct(ConfigurationRepository $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param int $group
     * @return array
     */
    public function get(int $group): array
    {
        $ids = $this->getIds($group);
        $rows = $this->configuration->getByIds($ids);
        $result = [];
        foreach ($rows as $row) {
            $values = array_map('trim', explode("\r\n", $row['value']));
            if (count($values) === 1) {
                $values = $values[0];
            }
            $result[$row['key']] = $values;
        }

        return $result;
    }

    /**
     * @param int $group
     * @return array
     */
    protected function getIds(int $group): array
    {
        $ids = $this->configuration->getIdsByGroup($group);

        return array_map(function(array $id) : int {
            return $id['configurationId'];
        }, $ids);
    }
}

