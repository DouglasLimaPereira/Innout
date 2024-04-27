<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/commum.css">
    <link rel="stylesheet" href="assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/template.css">
    <title>In N' Out</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <i class="icofont-travelling mr-2"></i>
            <span class="font-weight-light">In</span>
            <span class="font-weight-bold mx-2">N'</span>
            <span class="font-weight-light">Out</span>
            <i class="icofont-runner-alt-1 ml-2"></i>
        </div>
        <div class="menu-toggle mx-3">
            <i class="icofont-navigation-menu"></i>
        </div>
        <div class="spacer mr-3">
            <div class="dropdown dropdown-toggle" data-bs-toggle="dropdown">
                <img class="avatar" src="<?="http://www.gravatar.com/avatar.php?gravatar_id=" . md5(strtolower(trim($_SESSION['user']->email)))?>" alt="user">
                <span >  
                    <?=$_SESSION['user']->name?>
                </span>
            </div>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li>
                    <a class="dropdown-item" href="logout.php">
                        <i class="icofont-logout"></i> Sair
                    </a>
                </li>
                <!-- <li><hr class="dropdown-divider"></li> -->
                <!-- <li><a class="dropdown-item" href="#">Another action</a></li> -->
            </ul>
        </div>
    </header>