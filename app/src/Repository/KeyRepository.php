<?php

namespace App\Repository;

use App\Entity\Key;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Key|null find($id, $lockMode = null, $lockVersion = null)
 * @method Key|null findOneBy(array $criteria, array $orderBy = null)
 * @method Key[]    findAll()
 * @method Key[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Key::class);
    }

    /**
     * @param string $delimiter
     *
     * @return int|mixed|string
     */
    public function getExportKeys($delimiter = '.')
    {
        $listKeys = $this->createQueryBuilder('k')
            ->leftJoin('k.translations', 't')
            ->leftJoin('t.language', 'l')
            ->select('k.name as key')
            ->addSelect('t.textValue as value')
            ->addSelect('l.name as language')
            ->addSelect('l.iso')
            ->getQuery()
            ->getResult()
            ;

        $newList = [];
        foreach ($listKeys as $keyArray) {
            $newList[$keyArray['language'].$delimiter.$keyArray['iso']][$keyArray['key']] = $keyArray['value'];
        }

        return $newList;
    }
}
