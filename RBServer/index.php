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
                    <a class="navbar-brand" href="#">Restaurant Buddy | {Restaurant Name}</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#">Deliveries <span class="sr-only">(current)</span></a></li>
                        <li><a href="restaurant.php">Restaurant Management</a></li>
                        <li><a href="staff.php">Staff</a></li>
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
                    <option>Please select</option>
                </select>
            </div>
            <div class="form-group">
                <label for="deliveryCode">Delivery Code:</label>
                <input type="text" class="form-control" id="deliveryCode" placeholder="e.g 123">
            </div>
            <div class="form-group col-xs-6">
                <label for="lattitude">Lattitude:</label>
                <input type="text" class="form-control" id="lattitude" placeholder="e.g. 25.000">
            </div>
            <div class="form-group col-xs-6">
                <label for="longitude">Longitude:</label>
                <input type="text" class="form-control" id="longitude" placeholder="e.g. 25.000">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary col-xs-6 col-xs-offset-3" style="margin-bottom: 30px">submit delivery</button><br>
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
                <tr>
                    <td>
                        Ruan Botes
                    </td>
                    <td>
                        ab123
                    </td>
                    <td>
                        lat long
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs">delivered</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        Ruan Botes
                    </td>
                    <td>
                        ab345
                    </td>
                    <td>
                        lat long
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs">delivered</button>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
