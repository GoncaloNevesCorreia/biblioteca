<?php 
require 'model/dbh.php';
session_start();
if (isset($_SESSION['user'])) { // Verifica se o user está autenticado
    if (isset($_POST['page_no']) && $_POST['page_no']!="") {
        $page_no = $_POST['page_no'];
    } else {
        $page_no = 1;
    }


    if (isset($_POST["req"])) {
        $id = $_POST["id"];
        $requisitante = $_POST["requisitante"];

        if (!(empty($id) || empty($requisitante))) {
            $id = intval($id);
            $a = "";


            $stmt = $conn->prepare("INSERT INTO `requisicoes`(`codLivro`, `requisitante`, `userName`) VALUES (?, ?, ?)");
            $stmt->bind_param('iss', $id, $requisitante, $a); // 's' specifies the variable type => 'string'
            $stmt->execute();

            $stmt = $conn->prepare("UPDATE `livros` SET `requisitado`= 1 WHERE `ID` = ?");
            $stmt->bind_param('i', $id); // 's' specifies the variable type => 'string'
            $stmt->execute();

            header("Location: requisicoes.php?page_no=$page_no&control=requisitar");
            exit();
        }
    } else if (isset($_POST["delv"])) {
        $id = $_POST["id"];

        
        if (!empty($id)) {
            $id = intval($id);
            $stmt = $conn->prepare("UPDATE `requisicoes` SET `devolvido`= 1 WHERE `codLivro` = ? and devolvido = 0;");
            $stmt->bind_param('i', $id); // 's' specifies the variable type => 'string'
            $stmt->execute();


            $stmt = $conn->prepare("UPDATE `livros` SET `requisitado`= 0 WHERE `ID` = ?;");
            $stmt->bind_param('i', $id); // 's' specifies the variable type => 'string'
            $stmt->execute();
        
            header("Location: requisicoes.php?page_no=$page_no&control=devolver");
            exit();
        }
        
    }

    header("Location: requisicoes.php?page_no=$page_no");
    exit();
} else {
    header("Location: login.php");
    exit();
}