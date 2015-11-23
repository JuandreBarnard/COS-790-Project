<?php
    require_once __DIR__ . '/carbon/core.ini.php';
    require_once __DIR__ . '/carbon/requests/requests.inc.php';
    require_once __DIR__ . '/carbon/responses/responses.inc.php';
    require_once __DIR__ . '/carbon/formats/formats.inc.php';
    require_once __DIR__ . '/src/restaurant/restaurant.php';

    $db = $config->getDefaultDatabase()->open();
    
    $restaurant_id = $_GET['restaurant_id'];
    
    $restaurantInfo = null;
    
    $response = getRestaurantByIdWithoutLogo($db, $restaurant_id);
    
    if($response->getType() == Response::SUCCESS){
        $restaurantInfo = $response->getData();
    }
    
    $deliveryMen = null;
    
    $response = getDeliveryMen($db, $restaurant_id);
    
    if($response->getType() == Response::SUCCESS){
        $deliveryMen = $response->getData();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin | Staff</title>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1' />
        <link rel='stylesheet' type='text/css' href='/RBServer/lib/bootstrap.min.css' />
        <link type='text/css' rel='stylesheet' href='/RBServer/lib/font-awesome.min.css' />
        <script src="/RBServer/lib/jquery.min.js"></script>
        <script src="/RBServer/lib/bootstrap.min.js"></script>
        <script src="/RBServer/js/restaurant.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Restaurant Buddy | <?php echo $restaurantInfo['restaurantName'] ?></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php?restaurant_id=<?php echo $restaurant_id ?>">Deliveries <span class="sr-only">(current)</span></a></li>
                        <li><a href="restaurant.php?restaurant_id=<?php echo $restaurant_id ?>">Restaurant Management</a></li>
                        <li class="active"><a href="#">Staff</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="col-xs-6 col-xs-offset-3">
            <table class="table table-hover">
                <tr>
                    <th>
                        Staff Fullname
                    </th>
                    <th>
                        Staff Email
                    </th>
                    <th>
                        
                    </th>
                </tr>
                <?php
                    if($deliveryMen != null){
                        foreach($deliveryMen as $deliveryMan){
                ?>
                <tr>
                    <td>
                        <?php echo $deliveryMan['fullname'] ?>
                    </td>
                    <td>
                        <?php echo $deliveryMan['email'] ?>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs" onclick="deleteDeliveryMan(<?php echo $deliveryMan['id'] ?>, <?php echo $restaurant_id ?>)">delete</button>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
            <div class="form-group">
                <label for="fullname">Fullname:</label>
                <input type="text" class="form-control" id="fullname" placeholder="">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary col-xs-6 col-xs-offset-3" onclick="addDeliveryMan(<?php echo $restaurant_id ?>)">add delivery man</button>
            </div>
        </div>
    </body>
</html>
