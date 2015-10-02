<?php

function registerUser(PDO $db, $user){
    $query = '  INSERT INTO 
                    users(
                        firstname,
                        lastname,
                        displayname,
                        email,
                        password,
                        type,
                        gcmregid,
                        created,
                        updated
                    )
                VALUES(
                    :firstname,
                    :lastname,
                    :displayname,
                    :email,
                    PASSWORD(":password"),
                    :type,
                    :gcmregid
                    NOW(),
                    NOW()
                )' ;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':firstname', $user->firstname, PDO::PARAM_STR);
        $statement->bindValue(':lastname', $user->lastname, PDO::PARAM_STR);
        $statement->bindValue(':displayname', $user->displayname, PDO::PARAM_STR);
        $statement->bindValue(':email', $user->email, PDO::PARAM_STR);
        $statement->bindValue(':password', $user->password, PDO::PARAM_STR);
        $statement->bindValue(':type', $user->type, PDO::PARAM_INT);
        $statement->bindValue(':gcmregid', $user->lastname, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            $userId = $db->lastInsertId();
            return getUserById($db, $userId);
        }

        return new ErrorResponse('User could not be registered.');
    } catch (PDOException $ex) {
        return new ExceptionResponse('PDOException was caught.', $ex);
    }
}

function getUserById($db, $user_id){
    try {
        $query = '
            SELECT
                id,
                firstname,
                lastname,
                displayname,
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
