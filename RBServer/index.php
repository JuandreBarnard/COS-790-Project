<?php
    require_once __DIR__ . '/carbon/core.ini.php';
    require_once __DIR__ . '/carbon/requests/requests.inc.php';
    require_once __DIR__ . '/carbon/responses/responses.inc.php';
    require_once __DIR__ . '/carbon/formats/formats.inc.php';
    require_once __DIR__ . '/src/restaurant/restaurant.php';

    $db = $config->getDefaultDatabase()->open();
    
    $restaurant_id = $_GET['restaurant_id'];
    
    $deliveries = null;
    
    $response = getDeliveries($db, $restaurant_id);
    
    if($response->getType() == Response::SUCCESS){
        $deliveries = $response->getData();
    }
    
    $deliveryMen = null;
    
    $response = getDeliveryMen($db, $restaurant_id);
    
    if($response->getType() == Response::SUCCESS){
        $deliveryMen = $response->getData();
    }
    
    $restaurantInfo = null;
    
    $response = getRestaurantByIdWithoutLogo($db, $restaurant_id);
    
    if($response->getType() == Response::SUCCESS){
        $restaurantInfo = $response->getData();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin | Deliveries</title>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1' />
        <link rel='stylesheet' type='text/css' href='/lib/bootstrap.min.css' />
        <link type='text/css' rel='stylesheet' href='/lib/font-awesome.min.css' />
        <script src="/lib/jquery.min.js"></script>
        <script src="/lib/bootstrap.min.js"></script>
        <script src="/js/index.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Restaurant Buddy | <?php echo $restaurantInfo['restaurantName'] ?></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#">Deliveries <span class="sr-only">(current)</span></a></li>
                        <li><a href="restaurant.php?restaurant_id=<?php echo $restaurant_id ?>">Restaurant Management</a></li>
                        <li><a href="staff.php?restaurant_id=<?php echo $restaurant_id ?>">Staff</a></li>
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
            <div class="form-group">
                <label for="deliveryMan">Delivery Man:</label>
                <select class="form-control" id="deliveryMan">
                    <option value="0">Please select</option>
                    <?php
                        if($deliveryMen != null){
                            foreach($deliveryMen as $deliveryMan){
                    ?>
                    <option value="<?php echo $deliveryMan['id'] ?>"><?php echo $deliveryMan['fullname'] ?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="deliveryCode">Delivery Code:</label>
                <input type="text" class="form-control" id="deliveryCode" placeholder="e.g 123">
            </div>
            <div class="form-group col-xs-6">
                <label for="lattitude">Lattitude:</label>
                <input type="text" class="form-control" id="lattitude" placeholder="e.g. 25.000" value="-25.7288130">
            </div>
            <div class="form-group col-xs-6">
                <label for="longitude">Longitude:</label>
                <input type="text" class="form-control" id="longitude" placeholder="e.g. 25.000" value="28.2462700">
            </div>
            <div class="form-group text-center">
                <button id="submit-button" class="btn btn-primary col-xs-6 col-xs-offset-3" style="margin-bottom: 30px" onclick="submitDelivery()" id="submit-button">submit delivery</button><br>
            </div>
        </div>
        <div class="col-xs-6 col-xs-offset-3">
            <table class="table table-hover">
                <tr>
                    <th>
                        Delivery Man
                    </th>
                    <th>
                        Delivery Code
                    </th>
                    <th>
                        Location
                    </th>
                    <th>
                        
                    </th>
                </tr>
                <?php                
                    if($deliveries != null){
                        foreach ($deliveries as $delivery) {
                ?>
                <tr>
                    <td>
                        <?php echo $delivery['fullname'] ?>
                    </td>
                    <td>
                        <?php echo $delivery['order_number'] ?>
                    </td>
                    <td>
                        <?php echo $delivery['lattitude'] . ", " . $delivery['longitude'] ?>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs" onclick="deleteDelivery(<?php echo $delivery['id'] ?>)">delivered</button>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
        </div>
    </body>
</html>
