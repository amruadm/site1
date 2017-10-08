<?php

namespace AppBundle\Entity\Minecraft;

use Symfony\Component\HttpFoundation\File\File;

abstract class MinecraftTexture
{
    public abstract function getImage();
    public abstract function setImage(File $imageFile);
}