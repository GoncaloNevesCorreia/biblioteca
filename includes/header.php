<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>

    <link href="https://fonts.googleapis.com/css2?family=Sriracha&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Gestão</a>
    </div>
    <ul class="nav navbar-nav">
      <li <?php if($_SERVER['SCRIPT_NAME']=="/Biblioteca/livros.php") { ?>  class="active"   <?php   }  ?>><a href="livros.php">Adicionar livros</a></li>
      <li <?php if($_SERVER['SCRIPT_NAME']=="/Biblioteca/requisicoes.php") { ?>  class="active"   <?php   }  ?> ><a href="requisicoes.php">Requisições</a></li>
      
      
      <li style=""><a href="logout.php">Terminar Sessão</a></li>
    </ul>
  </div>
</nav>