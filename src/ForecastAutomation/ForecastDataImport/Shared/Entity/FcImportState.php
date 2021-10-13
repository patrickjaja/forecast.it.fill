<?php

namespace ForecastAutomation\ForecastDataImport\Shared\Entity;

use DateTimeInterface;
use ForecastAutomation\ForecastDataImport\ForecastDataImportRepository;
use Doctrine\ORM\Mapping as ORM;
use ForecastAutomation\Kernel\Shared\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=ForecastDataImportRepository::class)
 */
class FcImportState extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id_import_state;

    /**
     * @ORM\Column(type="integer")
     */
    private int $fk_person_id;

    /**
     * @ORM\Column(type="string")
     */
    private string $activity_plugin_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $last_import_timestamp;

    public function getIdImportState(): int
    {
        return $this->id_import_state;
    }

    public function setIdImportState(int $id_import_state): self
    {
        $this->id_import_state = $id_import_state;

        return $this;
    }

    public function getFkPersonId(): int
    {
        return $this->fk_person_id;
    }

    public function setFkPersonId(int $fk_person_id): self
    {
        $this->fk_person_id = $fk_person_id;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->last_import_timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->last_import_timestamp = $timestamp;

        return $this;
    }
}
