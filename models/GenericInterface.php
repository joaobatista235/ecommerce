<?php
interface GenericInterface
{
    public function save();
    public  function getById(int $id);
    public  function getAll();
    public function delete();
}