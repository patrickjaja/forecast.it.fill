<?php

namespace ForecastAutomation\MattermostClient;

use Doctrine\Persistence\ManagerRegistry;
use ForecastAutomation\Kernel\AbstractRepository;
use ForecastAutomation\MattermostClient\Shared\Entity\MattermostUserSettings;

/**
 * @method MattermostUserSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method MattermostUserSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method MattermostUserSettings[]    findAll()
 * @method MattermostUserSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MattermostClientRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MattermostUserSettings::class);
    }
}
