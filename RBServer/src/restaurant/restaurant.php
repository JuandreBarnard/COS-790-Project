<?php

function getRestaurantById($db, $restaurant_id){
    try {
        $query = '
            SELECT
                restaurant_id,
                restaurantName,
                restaurantStreet,
                restaurantCity,
                restaurantProvince,
                restaurantCountry
            FROM
                restarants
            WHERE 
                id = :id;
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
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
                RES.restaurantCountry
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
            return new SuccessResponse('User has restaurants.', $data);
        }

        return new ErrorResponse('No restaurants found for user.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function getAllRestaurants($db){
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
                restaurants;
        ';

        $statement = $db->prepare($query);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return new SuccessResponse('Restaurants exists.', $data);
        }

        return new ErrorResponse('Restaurants does not exist.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function createUserPlace(PDO $db, $user_id, $restaurant_id){
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
            $userId = $db->lastInsertId();
            $response = getUserById($db, $userId);
            
            if($response->getType() == Response::SUCCESS){
                return new SuccessResponse("User place created.", $response->getData());
            }
            else{
                return $response;
            }
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
            $userId = $db->lastInsertId();
            $response = getUserById($db, $userId);
            
            if($response->getType() == Response::SUCCESS){
                return new SuccessResponse("User place deleted.", $response->getData());
            }
            else{
                return $response;
            }
        }

        return new ErrorResponse('User place could not be deleted.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}