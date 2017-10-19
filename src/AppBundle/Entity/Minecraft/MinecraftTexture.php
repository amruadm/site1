<?php

namespace AppBundle\Entity\Minecraft;

abstract class MinecraftTexture
{
    public abstract function getImage();
    public abstract function setImage($imageFile);
}