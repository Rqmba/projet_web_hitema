<?php

namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\ByteString;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsDoctrineListener(event: Events::prePersist)]
#[AsDoctrineListener(event: Events::postLoad)]
#[AsDoctrineListener(event: Events::preUpdate)]
#[AsDoctrineListener(event: Events::preRemove)] 
class ArticleListener
{
    public function __construct(readonly private SluggerInterface $slugger, readonly private Filesystem $filesystem) 
    {
       
    }

    public function postLoad(PostLoadEventArgs $event):void
    {
        $entity = $event->getObject();

        if ($entity instanceof Article) {
            $entity->prevPicture= $entity->getPicture();
            // dd($entity);
        }
    }

    public function prePersist(PrePersistEventArgs $event):void
    {
        $entity = $event->getObject();

        if ($entity instanceof Article) {
            $entity->setSlug(
                $this->slugger->slug($entity->getTitle())->lower()
            );

        if ($entity->getPicture() instanceof UploadedFile) {
            $uploadedFile = $entity->getPicture();

            $fileName = ByteString::fromRandom(32)->lower() . '.' . $uploadedFile->guessExtension();

            $uploadedFile->move('img', $fileName);

            $entity->setPicture($fileName);
            
        }    
        }
    }

    public function preUpdate(PreUpdateEventArgs $event):void
    {
        $entity = $event->getObject();
        if ($entity instanceof Article) {
            $entity->setSlug(
                $this->slugger->slug($entity->getTitle())->lower()
            );

        if ($entity->getPicture() instanceof UploadedFile) {
            $this->filesystem->remove(
                "img/{$entity->prevImage}"
            );

            $uploadedFile = $entity->getPicture();
            $fileName = ByteString::fromRandom(32)->lower() . ".
        {$uploadedFile->guessExtension()}";
        $uploadedFile->move('img', $fileName);

        $entity->setPicture($fileName);
        return;
        }
        }
    }

    public function preRemove(PreRemoveEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof Article) {
            $this->filesystem->remove("img/{$entity->prevImage}"
        );
        }
    }
}