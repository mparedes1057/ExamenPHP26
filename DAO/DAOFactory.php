<?php

namespace DAO;
use Inteficies\NotesDAO;

class DAOFactory
{
    public static function createNotesDAO() :NotesDAO
    {
        return new NotesDAOImpl();
    }
}