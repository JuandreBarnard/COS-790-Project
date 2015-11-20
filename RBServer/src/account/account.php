<?php

function registerUser(PDO $db, $user){
    $response = getUserByEmail($db, $user->email);
    if($response->getType() == Response::SUCCESS){
        return new ErrorResponse("User already exist.", $user);
    }
    
    $query = '  INSERT INTO 
                    users(
                        fullname,
                        email,
                        password,
                        type,
                        gcmregid,
                        created,
                        updated
                    )
                VALUES(
                    :fullname,
                    :email,
                    password(:password),
                    :type,
                    :gcmregid,
                    NOW(),
                    NOW()
                )' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':fullname', $user->fullname, PDO::PARAM_STR);
        $statement->bindValue(':email', $user->email, PDO::PARAM_STR);
        $statement->bindValue(':password', $user->password, PDO::PARAM_STR);
        $statement->bindValue(':type', $user->type, PDO::PARAM_INT);
        $statement->bindValue(':gcmregid', $user->gcmregid, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $userId = $db->lastInsertId();
            $response = getUserById($db, $userId);
            
            if($response->getType() == Response::SUCCESS){
                return new SuccessResponse("User created.", $response->getData());
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

function loginUser($db, $user){
    try {
        $query = '
            SELECT
                id,
                fullname,
                type,
                gcmregid,
                created,
                updated
            FROM
                users
            WHERE 
                email = :email AND
                password = PASSWORD(:password);
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $user->email, PDO::PARAM_STR);
        $statement->bindValue(':password', $user->password, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            return new SuccessResponse('User exists.', $data);
        }

        return new ErrorResponse('User does not exist.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function getUserById($db, $user_id){
    try {
        $query = '
            SELECT
                id,
                fullname,
                email,
                type,
                gcmregid,
                created,
                updated
            FROM
                users
            WHERE 
                id = :id;
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            return new SuccessResponse('User exists.', $data);
        }

        return new ErrorResponse('User does not exist.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function getUserByEmail($db, $user_email){
    try {
        $query = '
            SELECT
                id,
                fullname,
                email,
                type,
                gcmregid,
                created,
                updated
            FROM
                users
            WHERE 
                email = :email;
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $user_email, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            return new SuccessResponse('User exists.', $data);
        }

        return new ErrorResponse('User does not exist.');
    } catch (PDOException $ex) {
        return new ExceptionResponse($ex);
    }
}

function createUser(PDO $db, $user){
    $response = getUserByEmail($db, $user->email);
    if($response->getType() == Response::SUCCESS){
        return new ErrorResponse("User already exist.", $user);
    }
    
    $query = '  INSERT INTO 
                    users(
                        fullname,
                        email,
                        type,
                        gcmregid,
                        created,
                        updated
                    )
                VALUES(
                    :fullname,
                    :email,
                    :type,
                    :gcmregid,
                    NOW(),
                    NOW()
                )' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':fullname', $user->fullname, PDO::PARAM_STR);
        $statement->bindValue(':email', $user->email, PDO::PARAM_STR);
        $statement->bindValue(':type', $user->type, PDO::PARAM_INT);
        $statement->bindValue(':gcmregid', $user->gcmregid, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $userId = $db->lastInsertId();
            $response = getUserById($db, $userId);
            
            if($response->getType() == Response::SUCCESS){
                return new SuccessResponse("User created.", $response->getData());
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