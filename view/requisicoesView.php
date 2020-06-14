<?php
    session_start();
    if (isset($_SESSION['user'])) { // Verifica se o user está autenticado
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

$reqChecked = true;

if (isset($_GET["control"])) {
    if ($_GET["control"] == "devolver") {
        $reqChecked = false;
    }
}


?>

<div class="wrapper-horizontal">


<?php 

    if (isset($_GET["control"])) {
        if ($_GET["control"] == "devolver") {
            include 'view/table-dev.php';
        } else {
            include 'view/table-livros.php';
        }
    }else {
        include 'view/table-livros.php';
    }


?>


<div>

<form method="get">
        <div class="custom-control custom-radio">
            <div><input type="radio" class="custom-control-input" id="requisitar" name="control" value="requisitar" <?php ($reqChecked) ? print("checked") : print(""); ?>>
            <label class="custom-control-label" for="requisitar">Requisitar</label></div>
            <div><input type="radio" class="custom-control-input" id="devolver" name="control" value="devolver" <?php ($reqChecked) ? print("") : print("checked"); ?>>
            <label class="custom-control-label" for="devolver">Devolver</label></div>
            <button type="submit" id="btnControl" class="hide"></button>
        </div>
</form>

    <div id="book-details">
        <form action="reqProcess.php" method="POST">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="tvControl" name="control">
            <input type="hidden" id="page_no" name="page_no" value="<?php echo $page_no; ?>">

            <div class="horizontal">
                <div class="some-margin">
                    <label for="isbn">ISBN:</label><br>
                    <input type="text" minlength="13" maxlength="13" id="isbn" name="isbn"><br>
                </div>
                <div id="num-wrapper">
                    <label for="num">Número:</label><br>
                    <input type="number" id="num" name="num" min="1"><br>
                </div>

               
            </div>
            <div id="num-wrapper">
                <label for="titulo">Titulo:</label><br>
                <input type="text" id="titulo" name="titulo"><br>
            </div>

               
            <label for="requisitante">Nome:</label><br>
            <input type="text" id="requisitante" name="requisitante"><br>
            

            <button id="btnPost" name="req" type="submit">Requisitar</button>
            <button type="button" class="hide" id="btnLimpar">Limpar</button>
        </form>
    </div>
</div>


    <script>

        var rows = <?php echo json_encode($rows); ?>;

    </script>

    
</div>

<script src="Assets/js/requisicoes.js"></script> 

<?php
    } else {
        header("Location: login.php");
        exit();
    }

?>