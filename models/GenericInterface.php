<?php
interface GenericInterface
{
    public function save();
    public static function getById($id);
    public static function getAll();
    public function delete();
}