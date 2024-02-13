<?php 
    class Service{
        public function createService($connection, $name, $price){
            $sql = "INSERT INTO services (name, price) VALUES (:name, :price)";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":price", $price, PDO::PARAM_INT);

            try{
                if($stmt->execute()){
                    $id = $connection->lastInsertId();
    
                    return $id;
                } else {
                    throw new Exception("Při vytváření služby došlo k chybě! ");
                }

            } catch (Exception $e) {
                error_log("Chyba u funkce createService. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function deleteService($connection, $id){
            $sql = "DELETE FROM services WHERE id=:id";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            try {
                if ($stmt->execute()){
                    return true;
                } else {
                    throw new Exception("Nepodařilo se smazat službu!");
                }
            } catch (Exception $e) {
                error_log("Chyba u funkce deleteService. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function getAllServices($connection){
            $sql = "SELECT * FROM services";

            $stmt = $connection->prepare($sql);
    
            try {
                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    throw new Exception("Nepodařilo se načíst seznam služeb z databáze! ");
                }
            } catch (Exception $e) {
                error_log("Chyba u funkce getAllServices. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function getOneService($connection, $id, $colums = "*"){
            $sql = "SELECT $colums FROM services WHERE id=:id";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            try{
                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    throw new Exception("Nepodařilo se načíst službu z databáze! ");
                }
            } catch (Exception $e) {
                error_log("Chyba u funkce getOneServices. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }
    }
?>