<?php
/**
 * Created by : Vincent SAISSET
 * Date: 05/09/13
 * Time: 14:56
 */

namespace Innova\CollecticielBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Claroline\CoreBundle\Entity\User;
use Innova\CollecticielBundle\Entity\Dropzone;

class DocumentRepository extends EntityRepository {

    /**
     *
     *  Fonctions créées pour InnovaCollecticielBundle.
     *  InnovaERV.
     *
    */

    /**
     *  Pour compter les documents déposés pour l'utilisateur indiqué et le dropzone indiqué
     * @param $userId
     * @param $dropzoneId
    */
    public function countDocSubmissions(User $user, Dropzone $dropzone)
    {

        /* requête avec CreateQuery : */
        $qb = $this->createQueryBuilder('document')
            ->select('document')
            ->leftJoin('document.drop', 'drop')
            ->andWhere('drop.user = :user')
            ->andWhere('drop.dropzone = :dropzone')
        /* InnovaERV : ajout de cette condition car on ne compte pas les documents déposés par l'enseignant */
            ->andWhere('drop.user = document.sender')
            ->setParameter('user', $user)
            ->setParameter('dropzone', $dropzone);
            ;

        $numberDocuments = count($qb->getQuery()->getResult());

        return $numberDocuments;

    }

    /**
     *  Pour compter les demandes addressées pour l'utilisateur indiqué
     * @param $userId
    */
    public function countTextToRead(User $user, Dropzone $dropzone)
    {

        /* requête avec CreateQuery : */
        $qb = $this->createQueryBuilder('document')
            ->select('document')
            ->leftJoin('document.drop', 'drop')
            ->andWhere('document.validate = true')
            ->andWhere('drop.user = :user')
            ->andWhere('drop.dropzone = :dropzone')
            ->andWhere('document.validate = 1')
            /* InnovaERV : ajout de cette condition car on ne compte pas les documents déposés par l'enseignant */
            ->andWhere('drop.user = document.sender')
            ->setParameter('user', $user)
            ->setParameter('dropzone', $dropzone);
            ;

        $numberDocuments = count($qb->getQuery()->getResult());
//        echo "Utilisateur numéro " . $user->getId() . " a " . $numberDocuments . " document(s)";die();

        return $numberDocuments;

    }

}
