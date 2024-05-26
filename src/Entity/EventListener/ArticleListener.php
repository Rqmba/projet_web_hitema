<?php

namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsDoctrineListener(event: Events::prePersist)]
#[AsDoctrineListener(event: Events::preUpdate)] 
class ArticleListener
{
    public function __construct(readonly private SluggerInterface $slugger) 
    {
       
    }

    public function prePersist(PrePersistEventArgs $event):void
    {
        $entity = $event->getObject();

        if ($entity instanceof Article) {
            $entity->setSlug(
                $this->slugger->slug($entity->getTitle())->lower()
            );
        }
    }

    public function preUpdate(PreUpdateEventArgs $event):void
    {
        $entity = $event->getObject();
        if ($entity instanceof Article) {
            $entity->setSlug(
                $this->slugger->slug($entity->getTitle())->lower()
            );
        }
    }
}