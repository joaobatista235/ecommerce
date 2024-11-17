<?php
interface GenericInterface
{
    public function save();
    public  function getById($id);
    public  function getAll();
    public function delete();
}