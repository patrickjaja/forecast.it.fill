<?php

namespace ForecastAutomation\GitlabClient;

use Doctrine\Persistence\ManagerRegistry;
use ForecastAutomation\GitlabClient\Shared\Entity\GitlabUserSettings;
use ForecastAutomation\Kernel\AbstractRepository;

/**
 * @method GitlabUserSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method GitlabUserSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method GitlabUserSettings[]    findAll()
 * @method GitlabUserSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GitlabUserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GitlabUserSettings::class);
    }
}
