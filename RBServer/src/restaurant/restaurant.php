<?php

function getRestaurantById($db, $restaurant_id){
    try {
        $query = '
            SELECT
                id,
                restaurantName,
                restaurantStreet,
                restaurantCity,
                restaurantProvince,
                restaurantCountry,
                lattitude,
                longitude,
                logo
            FROM
                restaurants
            WHERE 
                id = :id;
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            //$data['logo'] = base64_encode($data['logo']);
            file_put_contents('../../../tmp/' . $data['id'] . '.jpg', $data['logo']);
            $data['logo'] = $_SERVER['HTTP_HOST'] . '/tmp/' . $data['id'] . '.jpg';
            return new SuccessResponse('Restaurant exists.', $data);
        }

        return new ErrorResponse('Restaurant does not exist.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function getRestaurantByIdWithoutLogo($db, $restaurant_id){
    try {
        $query = '
            SELECT
                id,
                restaurantName,
                restaurantDescription,
                restaurantStreet,
                restaurantCity,
                restaurantProvince,
                restaurantCountry,
                lattitude,
                longitude
            FROM
                restaurants
            WHERE 
                id = :id;
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            //$data['logo'] = base64_encode($data['logo']);
            return new SuccessResponse('Restaurant exists.', $data);
        }

        return new ErrorResponse('Restaurant does not exist.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function getUserPlaces($db, $user){
    try {
        $query = '
            SELECT
                RES.id,
                RES.restaurantName,
                RES.restaurantStreet,
                RES.restaurantCity,
                RES.restaurantProvince,
                RES.restaurantCountry,
                RES.lattitude,
                RES.longitude,
                RES.logo
            FROM
                restaurants AS RES, user_places AS UP
            WHERE 
                RES.id = UP.restaurant_id AND
                UP.user_id = :id;
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $user->id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            for($i = 0; $i < count($data); $i++){
                file_put_contents('../../../tmp/' . $data[$i]['id'] . '.jpg', $data[$i]['logo']);
                $data[$i]['logo'] = $_SERVER['HTTP_HOST'] . '/RBServer/tmp/' . $data[$i]['id'] . '.jpg';
            }
            
            return new SuccessResponse('User has restaurants.', $data);
        }

        return new ErrorResponse('No restaurants found for user.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function getAllRestaurants($db, $user){
    try {
        $query = '
            SELECT
                id,
                restaurantName,
                restaurantDescription,
                restaurantStreet,
                restaurantCity,
                restaurantProvince,
                restaurantCountry,
                lattitude,
                longitude,
                logo
            FROM
                restaurants
            WHERE 
                id NOT IN (
                    SELECT 
                        restaurant_id
                    FROM
                        user_places
                    WHERE
                        user_id = :user_id
                );
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user->user_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($data); $i++){
                file_put_contents('../../../tmp/' . $data[$i]['id'] . '.jpg', $data[$i]['logo']);
                $data[$i]['logo'] = $_SERVER['HTTP_HOST'] . '/RBServer/tmp/' . $data[$i]['id'] . '.jpg';
            }
            return new SuccessResponse('Restaurants exists.', $data);
        }

        return new ErrorResponse('Restaurants does not exist.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function createUserPlace(PDO $db, $user_id, $restaurant_id){
    require_once __DIR__ . '/../account/account.php';
    $response = getUserById($db, $user_id);
    
    if($response->getType() != Response::SUCCESS){
        return new ErrorResponse("User does not exist.");
    }
    
    $query = '  INSERT INTO 
                    user_places(
                        user_id,
                        restaurant_id
                    )
                VALUES(
                    :user_id,
                    :restaurant_id
                )' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            return new SuccessResponse("User place created.", $response->getData());
        }

        return new ErrorResponse('User place could not be registered.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function deleteUserPlace(PDO $db, $user_id, $restaurant_id){
    $query = '  DELETE FROM 
                    user_places
                WHERE 
                    user_id = :user_id AND
                    restaurant_id = :restaurant_id' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            return new SuccessResponse("User place deleted.");
        }

        return new ErrorResponse('User place could not be deleted.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function submitGPS(PDO $db, $deliveryInfo){
    $query = '  UPDATE
                    deliveries
                SET
                    lattitude = :lattitude,
                    longitude = :longitude
                WHERE 
                    delivery_man_id = :delivery_man_id' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':delivery_man_id', $deliveryInfo->delivery_man_id, PDO::PARAM_INT);
        $statement->bindValue(':lattitude', $deliveryInfo->lattitude, PDO::PARAM_STR);
        $statement->bindValue(':longitude', $deliveryInfo->longitude, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            return new SuccessResponse("Delivery updated.");
        }

        return new ErrorResponse('Delivery could not be updated.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function getGPS(PDO $db, $deliveryInfo){
    $query = '  SELECT 
                    *
                FROM
                    deliveries
                WHERE 
                    order_number = :order_number' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':order_number', $deliveryInfo->order_number, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return new SuccessResponse("Delivery info could be retrieved.", $data);
        }

        return new ErrorResponse('Delivery info could not be retrieved.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function createDelivery(PDO $db, $deliveryInfo){
    $query = '  INSERT INTO
                    deliveries
                (
                    delivery_man_id,
                    order_number,
                    lattitude,
                    longitude
                )
                VALUES(
                    :delivery_man_id,
                    :order_number,
                    :lattitude,
                    :longitude
                )' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':delivery_man_id', $deliveryInfo->delivery_man_id, PDO::PARAM_INT);
        $statement->bindValue(':order_number', $deliveryInfo->order_number, PDO::PARAM_STR);
        $statement->bindValue(':lattitude', $deliveryInfo->lattitude, PDO::PARAM_STR);
        $statement->bindValue(':longitude', $deliveryInfo->longitude, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            return new SuccessResponse("Delivery created.");
        }

        return new ErrorResponse('Delivery could not be created.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function getDeliveries(PDO $db, $restaurant_id){
    $query = '  SELECT 
                    DEL.id,
                    USR.fullname,
                    DEL.order_number,
                    DEL.lattitude,
                    DEL.longitude
                FROM
                    deliveries AS DEL, users AS USR
                WHERE 
                    USR.id = DEL.delivery_man_id AND
                    delivery_man_id IN (
                        SELECT
                            user_id
                        FROM
                            restaurant_delivery_staff
                        WHERE
                            restaurant_id = :restaurant_id
                    )' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return new SuccessResponse("Delivery info could be retrieved.", $data);
        }

        return new ErrorResponse('Delivery info could not be retrieved.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function deleteDelivery(PDO $db, $deliveryInfo){
    $query = '  DELETE FROM
                    deliveries
                WHERE
                    id = :delivery_id' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':delivery_id', $deliveryInfo->delivery_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            return new SuccessResponse("Delivery deleted.");
        }

        return new ErrorResponse('Delivery could not be deleted.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function getDeliveryMen(PDO $db, $restaurant_id){
    $query = '  SELECT 
                    USR.id,
                    USR.fullname,
                    USR.email
                FROM
                    restaurant_delivery_staff AS DEL, users AS USR
                WHERE 
                    USR.id = DEL.user_id AND
                    DEL.restaurant_id = :restaurant_id' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return new SuccessResponse("Delivery info could be retrieved.", $data);
        }

        return new ErrorResponse('Delivery info could not be retrieved.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function updateRestaurant(PDO $db, $restaurantInfo){
    $query = '  UPDATE
                    restaurants
                SET
                    restaurantName = :restaurantName,
                    restaurantDescription = :restaurantDesc,
                    restaurantStreet = :restaurantStreet,
                    restaurantCity = :restaurantCity,
                    restaurantProvince = :restaurantProvince,
                    restaurantCountry = :restaurantCountry,
                    lattitude = :lattitude,
                    longitude = :longitude
                WHERE 
                    id = :id' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $restaurantInfo->id, PDO::PARAM_INT);
        $statement->bindValue(':restaurantName', $restaurantInfo->restaurantName, PDO::PARAM_STR);
        $statement->bindValue(':restaurantDesc', $restaurantInfo->restaurantDesc, PDO::PARAM_STR);
        $statement->bindValue(':restaurantStreet', $restaurantInfo->restaurantStreet, PDO::PARAM_STR);
        $statement->bindValue(':restaurantCity', $restaurantInfo->restaurantCity, PDO::PARAM_STR);
        $statement->bindValue(':restaurantProvince', $restaurantInfo->restaurantProvince, PDO::PARAM_STR);
        $statement->bindValue(':restaurantCountry', $restaurantInfo->restaurantCountry, PDO::PARAM_STR);
        $statement->bindValue(':lattitude', $restaurantInfo->lattitude, PDO::PARAM_STR);
        $statement->bindValue(':longitude', $restaurantInfo->longitude, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            return new SuccessResponse("Delivery updated.");
        }

        return new ErrorResponse('Delivery could not be updated.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function deleteDeliveryMan(PDO $db, $deliveryInfo){
    $query = '  DELETE FROM
                    restaurant_delivery_staff
                WHERE
                    user_id = :user_id AND
                    restaurant_id = :restaurant_id' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $deliveryInfo->user_id, PDO::PARAM_INT);
        $statement->bindValue(':restaurant_id', $deliveryInfo->restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            return new SuccessResponse("Delivery man deleted.");
        }

        return new ErrorResponse('Delivery man could not be deleted.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function addDeliveryMan($db, $deliveryManInfo){
    $response = addUser($db, $deliveryManInfo);
    
    if($response->getType() != Response::SUCCESS){
        return $response;
    }
    
    $query = '  INSERT INTO 
                    restaurant_delivery_staff(
                        user_id,
                        restaurant_id
                    )
                VALUES(
                    :user_id,
                    :restaurant_id
                )' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $response->getData(), PDO::PARAM_INT);
        $statement->bindValue(':restaurant_id', $deliveryManInfo->restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $userId = $db->lastInsertId();
            
            if($response->getType() == Response::SUCCESS){
                return new SuccessResponse("User created.", $userId);
            }
            else{
                return $response;
            }
        }

        return new ErrorResponse('User could not be registered.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function addUser(PDO $db, $user){
    $query = '  INSERT INTO 
                    users(
                        fullname,
                        email,
                        password,
                        type,
                        created,
                        updated
                    )
                VALUES(
                    :fullname,
                    :email,
                    password(:password),
                    3,
                    NOW(),
                    NOW()
                )' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':fullname', $user->fullname, PDO::PARAM_STR);
        $statement->bindValue(':email', $user->email, PDO::PARAM_STR);
        $statement->bindValue(':password', $user->password, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $userId = $db->lastInsertId();
            
            return new SuccessResponse("User created.", $userId);
        }

        return new ErrorResponse('User could not be registered.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}