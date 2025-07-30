<?php

class TaskGateway
{
    // Atributos
    private static $dbh;

    // Método de conexão
    public static function setConnection(PDO $dbh)
    {
        self::$dbh = $dbh;
        self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Métodos para manipulação do banco de dados
    public function create($title, $description, $status)
    {
        // Preparação a consulta
        $sth = self::$dbh->prepare("
            INSERT INTO tbTasks(id, title, description, status) 
            VALUES (:id, :title, :description, :status)
        ");

        // Passagem de parâmetros
        $sth->bindValue(':id', (self::getLastId() + 1), PDO::PARAM_STR);
        $sth->bindParam(':title', $title, PDO::PARAM_STR);
        $sth->bindParam(':description', $description, PDO::PARAM_STR);
        $sth->bindParam(':status', $status, PDO::PARAM_STR);

        // Execução
        $sth->execute();
    }
    public function read($id = null) {
        // Preparação da consulta
        $sth = self::$dbh->prepare("
            SELECT * FROM tbTasks" .
            (isset($id) ? " WHERE id = :id" : "")
        );

        // Passagem de parâmetros
        if(isset($id)) {
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
        }

        // Executando
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update($id, $title = "", $description = "", $status = "")
    {
        // Preparação da consulta
        $sth = self::$dbh->prepare("
            UPDATE tbTasks 
            SET title = :title, 
                description = :description, 
                status = :status
            WHERE id = :id
        ");

        // Passagem de parâmetros
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        if (isset($title)) {
            $sth->bindParam(':title', $title, PDO::PARAM_STR);
        }
        if (isset($description)) {
            $sth->bindParam(':description', $description, PDO::PARAM_STR);
        }
        if (isset($status)) {
            $sth->bindParam(':status', $status, PDO::PARAM_STR);
        }

        // Execução da consulta
        $sth->execute();
    }
    public function delete($id)
    {
        // Preparação da consulta
        $sth = self::$dbh->prepare("DELETE FROM tbTasks WHERE id = :id");

        // Passagem de parâmetros
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        // Execução da consulta
        $sth->execute();
    }
    public static function getLastId()
    {
        // Consulta
        $dbh = self::$dbh->query("SELECT id FROM tbTasks ORDER BY id DESC LIMIT 1");
        $result = $dbh->fetch(PDO::FETCH_NUM);
        return $result ? $result[0] : 0;
    }
}