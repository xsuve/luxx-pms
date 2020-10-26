<?php

class CryptoModel {

    // Database
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    // Get Account Cryptocurrencies
    public function getAccountCryptocurrencies($account_id, $limit = null) {
        $account_id = strip_tags($account_id);

        if($limit != null) {
            $sql = 'SELECT * FROM luxx_crypto WHERE account_id = :account_id LIMIT ' . $limit;
            $query = $this->db->prepare($sql);
            $query->execute(array(':account_id' => $account_id));
        } else {
            $sql = 'SELECT * FROM luxx_crypto WHERE account_id = :account_id';
            $query = $this->db->prepare($sql);
            $query->execute(array(':account_id' => $account_id));
        }

        return $query->fetchAll();
    }

    // Add Cryptocurrency
    public function addCryptocurrency($account_id, $cryptocurrency, $amount) {
        if(!empty($account_id) && !empty($cryptocurrency)) {
            $account_id = strip_tags($account_id);
            $cryptocurrency = strtoupper(strip_tags($cryptocurrency));
            $amount = strip_tags($amount);

            $sql = 'INSERT INTO luxx_crypto (account_id, cryptocurrency, amount) VALUES (:account_id, :cryptocurrency, :amount)';
            $query = $this->db->prepare($sql);
            $query->execute(array(':account_id' => $account_id, ':cryptocurrency' => $cryptocurrency, ':amount' => $amount));

            return 'The cryptocurrency has been added.';
        } else {
            return 'Please fill all the input fields.';
        }
    }

    // Delete Cryptocurrency
    public function deleteCryptocurrency($cryptocurrency_id) {
        if(!empty($cryptocurrency_id)) {
            $cryptocurrency_id = strip_tags($cryptocurrency_id);

            $sql = 'DELETE FROM luxx_crypto WHERE id = :cryptocurrency_id';
            $query = $this->db->prepare($sql);
            $query->execute(array(':cryptocurrency_id' => $cryptocurrency_id));

            return 'The cryptocurrency has been deleted.';
        } else {
            return 'No cryptocurrency id provided.';
        }
    }

}