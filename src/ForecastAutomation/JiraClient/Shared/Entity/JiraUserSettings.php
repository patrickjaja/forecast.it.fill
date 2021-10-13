<?php

namespace ForecastAutomation\JiraClient\Shared\Entity;

use DateTimeInterface;
use ForecastAutomation\JiraClient\JiraClientRepository;
use Doctrine\ORM\Mapping as ORM;
use ForecastAutomation\Kernel\Shared\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=JiraClientRepository::class)
 */
class JiraUserSettings extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public int $id_jira_user_settings;

    /**
     * @ORM\Column(type="integer")
     */
    public int $fk_user_id;

    /**
     * @ORM\Column(type="string")
     */
    public string $query_string;

    /**
     * @ORM\Column(type="string")
     */
    public string $token;

    /**
     * @ORM\Column(type="string")
     */
    public string $host;

    /**
     * @ORM\Column(type="string")
     */
    public string $user_name;

    /**
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $last_import_timestamp;
}
