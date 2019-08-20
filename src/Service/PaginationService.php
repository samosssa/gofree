<?php


namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class PaginationService{

    private $entityClass;
    private $limit = 9;
    private $currentPage = 1;
    private $manager;

    /**
     * PaginationService constructor.
     * @param $entityClass
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager= $manager;
    }

    public function getPages(){
        //connaitre le total des enregistrement de la table
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());

        $pages = ceil($total / $this->limit);

        return $pages;
    }

    public function getData(){
        // calculer l'offset
        $offset = $this->currentPage* $this->limit - $this->limit;

        //demander au repository de trouver les éléments
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([],[], $this->limit, $offset);

        // Renvoyer les éléments en question
        return $data;

    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $currentPage
     */
    public function setPage(int $page): void
    {
        $this->currentPage = $page;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }


    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }



}

