<!DOCTYPE html>
<html>
    <head>
        <title>Admin | Staff</title>
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
                        <li><a href="restaurant.php">Restaurant Management</a></li>
                        <li class="active"><a href="staff.php">Staff</a></li>
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
                <tr>
                    <td>
                        Ruan Botes
                    </td>
                    <td>
                        ruanbotes13@gmail.com
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs">delete</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        Juandre Barnard
                    </td>
                    <td>
                        jb@gmail.com
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs">delete</button>
                    </td>
                </tr>
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
            <div class="form-group">
                <label for="gcmregid">GCM Reg ID:</label>
                <input type="text" class="form-control" id="gcmregid" placeholder="">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary col-xs-6 col-xs-offset-3">add delivery man</button>
            </div>
        </div>
    </body>
</html>
