<?php

namespace AppBundle\Entity\Minecraft;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraint as Assert;

class SkinTexture extends MinecraftTexture
{
    /**
     * @Assert\NotBlank()
     * @Assert\File(
     *      mimeTypes = {
     *          "image/png"
     *      }
     * )
     * @Assert\Image(
     *     minWidth = 64,
     *     maxWidth = 512,
     *     minHeight = 32,
     *     maxHeight = 256
     * )
     */
    private $image;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(File $imageFile)
    {
        $this->image = $imageFile;
    }
}