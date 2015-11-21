<!DOCTYPE html>
<html>
    <head>
        <title>Admin | My Restaurant</title>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1' />
        <link rel='stylesheet' type='text/css' href='/lib/bootstrap.min.css' />
        <link type='text/css' rel='stylesheet' href='/lib/font-awesome.min.css' />
        <script src="/lib/jquery.min.js"></script>
        <script src="/lib/bootstrap.min.js"></script>
        <script src="/js/restaurant.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Restaurant Buddy | {Restaurant Name}</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Deliveries <span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Restaurant Management</a></li>
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
                <label for="restaurantName">Restaurant Name:</label>
                <input type="text" class="form-control" id="restaurantName" placeholder="">
            </div>
            <div class="form-group">
                <label for="restaurantDesc">Restaurant Description:</label>
                <textarea type="text" class="form-control" id="restaurantDesc" placeholder=""></textarea>
            </div>
            <div class="form-group">
                <label for="restaurantStreet">Adress:</label>
                <input type="text" class="form-control" id="restaurantStreet" placeholder="Street">
                <input type="text" class="form-control" id="restaurantCity" placeholder="City">
                <input type="text" class="form-control" id="restaurantProvince" placeholder="Province">
                <input type="text" class="form-control" id="restaurantCountry" placeholder="Country">
            </div>
            <div class="form-group col-xs-6">
                <label for="lattitude">Lattitude:</label>
                <input type="text" class="form-control" id="lattitude" placeholder="e.g. 25.000">
            </div>
            <div class="form-group col-xs-6">
                <label for="longitude">Longitude:</label>
                <input type="text" class="form-control" id="longitude" placeholder="e.g. 25.000">
            </div>
            <div class="form-group">
                <div class="col-xs-9">
                    <label for="logo">Logo:</label>
                    <input type="file" class="form-control">
                </div>
                <div class="col-xs-3">
                    <img src="test.jpg" alt="" class="img-rounded col-xs-12" id="logo">
                </div>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary col-xs-6 col-xs-offset-3" style="margin-top: 30px">submit restaurant changes</button>
            </div>
        </div>
    </body>
</html>
