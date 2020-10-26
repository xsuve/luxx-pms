<?php

class ManagerModel {

    // Database
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    // Get Contacts
    public function getContacts() {
        $sql = 'SELECT * FROM luxx_contacts ORDER BY id DESC';
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    // Get Projects
    public function getProjects() {
        $sql = 'SELECT * FROM luxx_projects ORDER BY id DESC';
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }


    // Get Invoices
    public function getInvoices() {
        $sql = 'SELECT * FROM luxx_invoices ORDER BY id DESC';
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

}