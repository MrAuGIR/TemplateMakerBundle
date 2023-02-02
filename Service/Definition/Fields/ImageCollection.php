<?php

namespace TemplateMakerBundle\Service\Definition\Fields;

use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Model\DataObject\Data\Hotspotimage;
use Pimcore\Model\DataObject\Data\ImageGallery;
use Pimcore\Model\ModelInterface;
use Pimcore\Tool;

class ImageCollection implements Field
{
    private const TYPE = "imageGallery";

    private string $baseUrl;

    public function __construct(){
        $this->baseUrl = Tool::getHostUrl();
    }

    public function match(string $fieldClass = ''): bool
    {
        return static::TYPE === $fieldClass;
    }

    public function extract(TypeDeclarationSupportInterface $data, ?ModelInterface $object, array $languages = []): array
    {
        $name = $data->getName();
        $getter = 'get'.$name;

        $return = [$name => []];

        $gallery = $object?->$getter() ?? [];

        /**
         * @var ImageGallery $gallery
         * @var Hotspotimage $hotSpotImage
         */
        foreach ($gallery->getItems() as $hotSpotImage) {
            $image = $hotSpotImage->getImage();
            $return[$name][] = [
                'type' => $image?->getType() ?? 'image',
                'id' => $image?->getId(),
                'path' => $this->baseUrl. $image?->getFullPath() ?? '',
                'fileName' => $image?->getFilename() ?? ''
            ];
        }
        return $return;
    }
}
