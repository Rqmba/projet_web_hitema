<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Form\Event\PostSetDataEvent;

final class ArticleTypeListener
{
    // public function onFormPostSetData(PostSetDataEvent $event): void
    // {
    //     dd(
    //         $event->getData(),
    //         $event->getForm(),
    //         $event->getForm()->getData(),
    //     );
    // }
}
