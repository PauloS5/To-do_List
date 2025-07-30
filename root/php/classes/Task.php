<?php
    require_once "../gateway/TaskGateway.php";

    class Task
    {
        // Atributos
        private static $conn;
        private $data;

        // Método de conexão
        public static function setConnection(PDO $dbh)
        {
            self::$conn = $dbh;
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            TaskGateway::setConnection(self::$conn);
        }

        // Métodos mágicos para manipular atributos
        public function __set($prop, $value)
        {
            $this->data[$prop] = $value;
        }
        public function __get($prop)
        {
            return $this->data[$prop];
        }

        // Métodos para manipular o banco através do gateway
        public static function findAll()
        {
            $gw = new TaskGateway();
            return $gw->read();
        }
        public function find()
        {
            $gw = new TaskGateway();

            if(isset($gw->read($this->id)[0])) {
                return $gw->read($this->id)[0];
            }

            return null;
        }
        public function register()
        {
            $gw = new TaskGateway();
            $gw->create($this->title, $this->description, "pending");

            $this->id = TaskGateway::getLastId();
            $this->status = "pending";
        }
        public function update()
        {
            $gw = new TaskGateway();
            $gw->update($this->id, $this->title, $this->description, $this->status);
        }
        public function delete()
        {
            $gw = new TaskGateway();
            $gw->delete($this->id);
        }
    }