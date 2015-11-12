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
                RES.restaurant_id,
                RES.restaurantName,
                RES.restaurantStreet,
                RES.restaurantCity,
                RES.restaurantProvince,
                RES.restaurantCountry
            FROM
                restarants AS RES, user_places AS UP
            WHERE 
                RES.id = UP.restaurant_id AND
                UP.user_id = :id;
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $user->id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
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
                restaurant_id,
                restaurantName,
                restaurantStreet,
                restaurantCity,
                restaurantProvince,
                restaurantCountry
            FROM
                restarants;
        ';

        $statement = $db->prepare($query);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            return new SuccessResponse('Restaurants exists.', $data);
        }

        return new ErrorResponse('Restaurants does not exist.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}