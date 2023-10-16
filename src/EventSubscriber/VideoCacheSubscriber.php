<?php

namespace App\EventSubscriber;

use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class VideoCacheSubscriber implements EventSubscriberInterface
{
    public function onAfterEntityDeletedEvent(AfterEntityDeletedEvent $event): void
    {
        $cache = new FilesystemAdapter();
        $cache->delete('playlist_videos');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityDeletedEvent::class => 'onAfterEntityDeletedEvent',
        ];
    }
}
