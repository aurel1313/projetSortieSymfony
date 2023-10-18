<?php

namespace App\Repository;

use App\Entity\Participants;
use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sorties>
 *
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    public function findByFilters(array $parameters, ?Participants $user) {
        $qb = $this->createQueryBuilder('t')->orderBy('t.id', 'ASC');
        if ($parameters['organizing']) {
            $qb->andWhere('t.participant_idparticipant = :user')->setParameter('user', $user);
        }
        if ($parameters['participating']) {
            $qb->join('t.participants', 'p');
            $qb->andWhere('p.id = :userId1')->setParameter('userId1', $user->getId());
        }
        if ($parameters['passed']) {
            $qb->andWhere('t.dateHeureDebut <= :now')->setParameter('now', new \DateTime());
        }
        if (!empty($parameters['campus'])) {
            $qb->andWhere('t.site_idsite = :campus')->setParameter('campus', $parameters['campus']);
//            $qb->join('t.participant_idparticipant', 'o');
//            $qb->andWhere('o.site_idsite = :campus')->setParameter('campus', $parameters['campus']);
        }
        if (!empty($parameters['name'])) {
            $qb->andWhere('t.nom LIKE :name')->setParameter('name', '%' . $parameters['name'] . '%');
        }
        if (!empty($parameters['dateStart'])) {
            $qb->andWhere('t.dateHeureDebut >= :dateStart')->setParameter('dateStart', $parameters['dateStart']);
        }
        if (!empty($parameters['dateEnd'])) {
            $qb->andWhere('DATE_ADD(t.dateTimeEnd, INTERVAL t.duree MINUTE) <= :dateEnd')->setParameter('dateEnd', $parameters['dateEnd']);
        }

        if ($parameters['not-participating']) {
            $participatingTrips = $this->createQueryBuilder('t')
                ->select('t.id')
                ->join('t.participants', 'p')
                ->andWhere('p.id = :userId2')
                ->setParameter('userId2', $user->getId())
                ->getQuery()->getSingleColumnResult();
            $resultQuery = $qb->select('t.id')->getQuery()->getSingleColumnResult();
            $diff = array_diff($resultQuery, $participatingTrips);
            $result = [];
            foreach ($diff as $id) {
                $result[] = $this->find($id);
            }
        } else {
            $result = $qb->getQuery()->getResult();
        }

        if (!empty($parameters['status'])) {
            switch ($parameters['status']) {
                case 'not-published':
                    foreach ($result as $key => $trip) {
                        if ($trip->getEtatIdetat()->getLibelle() !== 'En création') {
                            unset($result[$key]);
                        }
                    }
                    break;
                case 'available':
                    foreach ($result as $key => $trip) {
                        if (count($trip->getParticipants()) >= $trip->getNombreInscriptionMax() || $trip->getEtatIdetat()->getLibelle() !== 'Ouverte' || $trip->getDateLimiteInscription() <= new \DateTime()) {
                            unset($result[$key]);
                        }
                    }
                    break;
                case 'closed':
                    foreach ($result as $key => $trip) {
                        if (count($trip->getParticipants()) < $trip->getNombreInscriptionMax() && $trip->getDateLimiteInscription() > new \DateTime()) {
                            unset($result[$key]);
                        }
                    }
                    break;
                case 'canceled':
                    foreach ($result as $key => $trip) {
                        if ($trip->getEtatIdetat()->getLibelle() !== 'Activité annulée') {
                            unset($result[$key]);
                        }
                    }
                    break;
                case 'ongoing':
                    foreach ($result as $key => $trip) {
                        /** @var \DateTime $dateStart */
                        $dateStart = $trip->getDateHeureDebut();
                        $dateEnd = $dateStart->add(new \DateInterval('PT' . $trip->getDuree() . 'M'));
                        if ($trip->getDateHeureDebut() < new \DateTime() || $dateEnd > new \DateTime()) {
                            unset($result[$key]);
                        }
                    }
                    break;
            }
        }

        if ($user !== null && !in_array('ROLE_ADMIN', $user->getRoles()) && !$user->isAdministrateur()) {
            foreach ($result as $key => $trip) {
                if ($trip->getParticipantIdparticipant() !== $user && $trip->getEtatIdetat()->getLibelle() === 'En création') {
                    unset($result[$key]);
                }
            }
        }

        return $result;
    }
}
