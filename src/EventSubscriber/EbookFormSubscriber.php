<?php
namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EbookFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        ];
    }

    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $imagesRaw = $data['imagesRaw']; // Assuming 'imagesRaw' is the field name

        $imageFileNames = [];

        foreach ($imagesRaw as $image) {
            // You can perform any processing here, such as moving the file to a directory
            // and storing its filename in the array.
            $fileName = $image->getClientOriginalName();
            // Store the filename in the array
            $imageFileNames[] = $fileName;
        }

        // Set the processed data back to the form
        $data['imagesRaw'] = $imageFileNames;
        $event->setData($data);
    }
}
