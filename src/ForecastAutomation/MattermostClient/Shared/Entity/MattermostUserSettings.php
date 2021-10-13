<?php

namespace ForecastAutomation\MattermostClient\Shared\Entity;

use DateTimeInterface;
use ForecastAutomation\JiraClient\JiraClientRepository;
use Doctrine\ORM\Mapping as ORM;
use ForecastAutomation\Kernel\Shared\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=JiraClientRepository::class)
 */
class MattermostUserSettings extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public int $id_mattermost_user;

    /**
     * @ORM\Column(type="integer")
     */
    public int $fk_user_id;

    /**
     * @ORM\Column(type="string")
     */
    public string $pattern;

    /**
     * @ORM\Column(type="string")
     */
    public string $host;

    /**
     * @ORM\Column(type="string")
     */
    public string $user_name;

    /**
     * @ORM\Column(type="string")
     */
    public string $user_password;

    /**
     * @ORM\Column(type="string")
     */
    public string $team_id;

    /**
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $last_import_timestamp;
}
