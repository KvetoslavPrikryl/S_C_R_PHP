<?php

class User{
    public function createUser($connection, $first_name, $second_name, $password, $admin_name, $about_user, $img){

        $sql = "INSERT INTO user (first_name, second_name, password, admin_name, about_user, img)
            VALUES (:first_name, :second_name, :password, :admin_name, :about_user, :img)";
    

        $stmt = $connection->prepare($sql);
        
        $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
        $stmt->bindValue(":second_name", $second_name, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue("admin_name", $admin_name, PDO::PARAM_STR);
        $stmt->bindValue("about_user", $admin_name, PDO::PARAM_STR);
        $stmt->bindValue("img", $admin_name, PDO::PARAM_STR);

        try{
            if($stmt->execute()){
                $id = $connection->lastInsertId();

                return $id;
            } else {
                throw new Exception("Při vytváření uživatele došlo k chybě! ");
            }
        } catch (Exception $e) {
            error_log("Chyba u funkce createUser. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }

    }
    
    public function authentication($connection, $admin_name, $log_password){
        $sql = "SELECT password FROM user WHERE admin_name = :admin_name";
    
        $stmt = $connection->prepare($sql);
    
        $stmt->bindValue(":admin_name", $admin_name, PDO::PARAM_STR);

        try {
            if($stmt->execute()){
                var_dump($stmt);
                if($user = $stmt->fetch()){
                    var_dump($user);
                    return password_verify($log_password, $user[0]);
                }
            } else {
                throw new Exception("Autentikace se ezdařila! ");
            }
        } catch (Exception $e) {
            error_log("Chyba u funkce authentication. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }

    }

    public function getUserId($connection, $admin_name){
        $sql = "SELECT id FROM user WHERE admin_name = :admin_name";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":admin_name", $admin_name, PDO::PARAM_STR);

        try{
            if($stmt->execute()){

                $result = $stmt->fetch();
                $user_id = $result[0];
                
                return $user_id;
            } else {
                throw new Exception("Nepodařilo se získat ID uživatele! ");
            }
        } catch (Exception $e) {
            error_log("Chyba u funkce getUserId. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }
    }

    public static function updateUser($connection, $first_name, $second_name, $admin_name, $about_user, $id){
        $sql = "UPDATE user SET first_name = :first_name,
                                second_name = :second_name,
                                admin_name = :admin_name,
                                about_user = :about_user
                            WHERE id = :id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
        $stmt->bindValue(":second_name", $second_name, PDO::PARAM_STR);
        $stmt->bindValue(":admin_name", $admin_name, PDO::PARAM_STR);
        $stmt->bindValue(":about_user", $about_user, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        try{
            if($stmt->execute()){
                return true;
            } else {
                throw new Exception("Nepodařilo se uložit změny! ");
            }
        } catch (Exception $e){
            error_log("Chyba u funkce updateUser. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }
    } 

    public static function updateUserImage($connection, $img, $id){
        $sql = "UPDATE user SET img = :img WHERE id=:id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue("img", $img, PDO::PARAM_STR);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);

        try{
            if($stmt->execute()){
                return true;
            } else {
                throw new Exception("Nepodařilo se uložit obrázek! ");
            }
        } catch (Exception $e){
            error_log("Chyba u funkce updateUserImage. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }
    }

    public static function getUserParam($connection, $id, $colums = "*"){
        $sql = "SELECT $colums FROM user WHERE id = :id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        try {
            if($stmt->execute()){
                return  $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Získání dat o uživateli selhalo!");
            }
        } catch(Exception $e) {
            error_log("Chyba u funkce getUserParam. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }
    }
}