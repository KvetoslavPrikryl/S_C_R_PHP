<?php 
    class Image{

        public function createImage($connection, $image_text, $img_name, $service){
            $sql = "INSERT INTO image (image_text, img_name, service) VALUES (:image_text, :img_name, :service)";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":image_text", $image_text, PDO::PARAM_STR);
            $stmt->bindValue(":img_name", $img_name, PDO::PARAM_STR);
            $stmt->bindValue(":service", $service, PDO::PARAM_STR);

            try {
                if($stmt->execute()){
                    $id = $connection->lastInsertId();
                    return $id;
                } else {
                    throw new Exception("Při vytváření obrázku došlo k chybě! ");
                }
            } catch (Execute $e) {
                error_log("Chyba u funkce createImage. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function deleteImageFromDirectory($path){
            try {
                if(!file_exists($path)){
                    throw new Exception("Soubor neexistuje a proto nemůže být smazán!");
                }

                if(unlink($path)){
                    return true;
                } else {
                    throw new Exception("Při mazáni souboru došlo k chybě!");
                }
            } catch (Exception $e) {
                echo "Chyba: " . $e->getMessage(); 
            }
        }

        public static function deleteImage($connection, $id){
            $sql = "DELETE FROM image WHERE id=:id";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            try {
                if ($stmt->execute()){
                    return true;
                } else {
                    throw new Exception("Nepodařilo se smazat obrázek!");
                }
            } catch (Exception $e) {
                error_log("Chyba u funkce deleteImage. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function getAllImages($connection){

            $sql = "SELECT * FROM image";
            
            $stmt = $connection->prepare($sql);
    
            try {
                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    throw new Exception("Nepodařilo se načíst seznam obrázků z databáze! ");
                }
            } catch (Exception $e) {
                error_log("Chyba u funkce getAllImages. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
            
        }

        public static function getImage($connection, $id, $colums = "*"){
            $sql = "SELECT $colums FROM image WHERE id = :id";
    
            $stmt = $connection->prepare($sql);
    
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            try {
                if($stmt->execute()){                                    
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }else{
                    throw new Exception("Získání dat o jednom obrázku selhalo!");
                }
            }
            catch (Exception $e) {
                error_log("Chyba u funkce getImage. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }  
        }

    }