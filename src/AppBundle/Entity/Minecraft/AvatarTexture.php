<?php

namespace AppBundle\Entity\Minecraft;

use Symfony\Component\Validator\Constraints as Assert;

class AvatarTexture extends MinecraftTexture
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
     *     minHeight = 64,
     *     maxHeight = 512
     * )
     */
    private $image;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($imageFile)
    {
        $this->image = $imageFile;
    }
}