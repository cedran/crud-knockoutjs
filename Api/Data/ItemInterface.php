<?php
namespace Cedran\CrudKnockoutjs\Api\Data;

interface ItemInterface
{
    public function getId();
    public function getTitle();
    public function setTitle($title);
    public function getDescription();
    public function setDescription($description);
}
