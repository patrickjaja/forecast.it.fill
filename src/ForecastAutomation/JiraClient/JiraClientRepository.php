<?php

namespace ForecastAutomation\JiraClient;

use Doctrine\Persistence\ManagerRegistry;
use ForecastAutomation\JiraClient\Shared\Entity\JiraUserSettings;
use ForecastAutomation\Kernel\AbstractRepository;

/**
 * @method JiraUserSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method JiraUserSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method JiraUserSettings[]    findAll()
 * @method JiraUserSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JiraClientRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JiraUserSettings::class);
    }
}
