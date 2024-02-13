<?php 

    class Dog{

        public function createDog($connection, $name, $dog_sex, $color, $weight, $height, $pately, $body ){
            $sql = "INSERT INTO dogs (name, dog_sex, color, weight, height, pately, body) 
                    VALUES (:name, :dog_sex, :color, :weight, :height, :pately, :body)";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":dog_sex", $dog_sex, PDO::PARAM_STR);
            $stmt->bindValue(":color", $color, PDO::PARAM_STR);
            $stmt->bindValue(":weight", $weight, PDO::PARAM_INT);
            $stmt->bindValue(":height", $height, PDO::PARAM_INT);
            $stmt->bindValue(":pately", $pately, PDO::PARAM_STR);
            $stmt->bindValue(":body", $body, PDO::PARAM_STR);

            try{
                if($stmt->execute()){
                    $id = $connection->lastInsertId();
    
                    return $id;
                } else {
                    throw new Exception("Při vytváření psa došlo k chybě! ");
                }

            } catch (Exception $e) {
                error_log("Chyba u funkce createDog. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public function editDog($connection, $name, $dog_sex, $color, $weight, $height, $pately, $body, $id){
        
            $sql = "UPDATE dogs 
                            SET name = :name,
                                dog_sex = :dog_sex,
                                color = :color,
                                weight = :weight,
                                height = :height,
                                pately = :pately,
                                body = :body
                            WHERE id = :id";
    
            $stmt = $connection->prepare($sql);
    
            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":dog_sex", $dog_sex, PDO::PARAM_STR);
            $stmt->bindValue(":color", $color, PDO::PARAM_STR);
            $stmt->bindValue(":weight", $weight, PDO::PARAM_INT);
            $stmt->bindValue(":height", $height, PDO::PARAM_INT);
            $stmt->bindValue(":pately", $pately, PDO::PARAM_STR);
            $stmt->bindValue(":body", $body, PDO::PARAM_STR);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    
            try{
            if($stmt->execute()){
                return true;
            } else {
            throw new Exception("Při ukládání úpravy psa došlo k chybě! ");
            }
    
            } catch (Exception $e) {
            error_log("Chyba u funkce editDog. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function editDogImage($connection, $file, $img, $dog_name, $id, $error = 0){

            if($file != ""){
                $name = $file[0];
                $tmp_name = $file[1];
                $error = $file[2];
            } else {
                $name = "";
            }
           

            $new_image_dog_path = "../uploads/Dogs/" . $dog_name . "/";

            if($error === 0){
                
                try{

                    if(!file_exists("../uploads/Dogs/" . $dog_name)){
                        mkdir("../uploads/Dogs/" . $dog_name, 0777, true);
                    }
                    if($name != ""){
                        move_uploaded_file($tmp_name, $new_image_dog_path . $name);
                    }
                    

                    $sql = "UPDATE dogs 
                        SET $img = :img
                        WHERE id = :id";

                    $stmt = $connection->prepare($sql);

                    $stmt->bindValue(":img", $name, PDO::PARAM_STR);
                    $stmt->bindValue(":id", $id, PDO::PARAM_INT);

                
                    if($stmt->execute()){
                        return true;
                    } else {
                    throw new Exception("Při ukládání obrázků psa došlo k chybě! ");
                    }

                } catch (Exception $e) {
                    error_log("Chyba u funkce editDogImage. \n", 3, "../errors/error.log");
                    echo "Typ chyby: " . $e->getMessage();
                    }
            }
        }

        public static function deleteDog($connection, $id){
            $sql = "DELETE FROM dogs WHERE id=:id";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            try {
                if ($stmt->execute()){
                    return true;
                } else {
                    throw new Exception("Nepodařilo se smazat psa!");
                }
            } catch (Exception $e) {
                error_log("Chyba u funkce deleteDog. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

        public static function deleteDogImage($connection, $dog_name, $dog_image){
            $image_dog_path = "../uploads/Dogs/" . $dog_name . "/" . $dog_image;
            try{
                if(file_exists($image_dog_path)){
                    unlink($image_dog_path);
                } else {
                    throw new Exception("Nepodařilo se smazat obrázek psa!");
                }
            } catch (Exception $e) {
                error_log("Chyba u funkce deleteDogImage. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
            
        }

        public static function getAllDogs($connection){

            $sql = "SELECT * FROM dogs";
            
            $stmt = $connection->prepare($sql);
    
            try {
                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    throw new Exception("Nepodařilo se načíst seznam psů z databáze! ");
                }
            } catch (Exception $e) {
                error_log("Chyba u funkce getAllDogs. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
            
        }

        public static function getDog($connection, $id, $colums = "*"){
            $sql = "SELECT $colums FROM dogs WHERE id = :id";
    
            $stmt = $connection->prepare($sql);
    
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            try {
                if($stmt->execute()){                                    
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }else{
                    throw new Exception("Získání dat o jednom psovi selhalo!");
                }
            }
            catch (Exception $e) {
                error_log("Chyba u funkce getDog. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }  
        }
    }

    