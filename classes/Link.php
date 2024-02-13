<?php

    class Link{
        public function createLink($connection, $name, $link, $text){
            $sql = "INSERT INTO links (name, link, text) VALUES (:name, :link, :text)";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":link", $link, PDO::PARAM_STR);
            $stmt->bindValue(":text", $text, PDO::PARAM_STR);

            try{
                if($stmt->execute()){
                    $id = $connection->lastInsertId();
                    return $id;
                } else {
                    throw new Exception("Při vytváření odkazu došlo k chybě! ");
                }
            } catch(Exception $e) {
                error_log("Chyba u funkce createLink. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function deleteLink($connection, $id){
            $sql = "DELETE FROM links WHERE id=:id";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            try{
                if($stmt->execute()){
                    return true;
                } else {
                    throw new Exception("Při mazání odkazu z databáze došlo k chybě! ");
                }
            } catch(Exception $e) {
                error_log("Chyba u funkce deleteLink. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function getAllLink($connection){
            $sql = "SELECT * FROM links";

            $stmt = $connection->prepare($sql);

            try{
                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    throw new Exception("Nepodařilo se načíst seznam odkazů z databáze! ");
                }
            } catch(Exception $e) {
                error_log("Chyba u funkce getAllLink. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }
    }