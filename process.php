<?php
    require 'model/dbh.php';
    session_start();
    if (isset($_SESSION['user'])) { // Verifica se o user está autenticado

    if (isset($_POST['page_no']) && $_POST['page_no']!="") {
        $page_no = $_POST['page_no'];
    } else {
        $page_no = 1;
    }

    if (isset($_POST["add"])) {
        $ISBN = $_POST["isbn"];
        $quant = $_POST["quantidade"];
        $titulo = $_POST["titulo"];
        $autor = $_POST["autor"];
        $editora = $_POST["editora"];
        $genero = $_POST["genero"];
        $edicao = $_POST["edicao"];
        $estado = $_POST["estado"];
        

        // Se todos os campos foram preenchidos....
        if (!(empty($ISBN) | empty($titulo) | empty($autor) | empty($editora) | empty($genero) | empty($edicao) | empty($estado))) {
            $ISBN = floatval($_POST["isbn"]);
            $quant = intval($_POST["quantidade"]);
            
            
            
            $strFormat = "dissssss";
            $strFormatSum = "";
            $bindArray;
            $arrayValuesSum = [];

            for ($i=1; $i <= $quant; $i++) { 
                $bindVals = "(?, ?, ?, ?, ?, ?, ?, ?)";
                $bindArray[] = $bindVals;
                $strFormatSum .= $strFormat;
                $arrayValues = [$ISBN, $i, $titulo, $genero, $autor, $editora, $edicao, $estado];
                $arrayValuesSum = array_merge($arrayValuesSum, $arrayValues);
            }

            $values = implode(', ', $bindArray);
            $Sqlquery = "INSERT INTO livros(ISBN, num, titulo, genero, autor, editora, edicao, estado) VALUES $values";
            $stmt = $conn->prepare($Sqlquery);
            $stmt->bind_param($strFormatSum, ...$arrayValuesSum);
            $stmt->execute();
            

            header("Location: livros.php?page_no=$page_no");
            exit();

        }
        
    } else if (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $ISBN = $_POST["isbn"];
        $titulo = $_POST["titulo"];
        $autor = $_POST["autor"];
        $editora = $_POST["editora"];
        $genero = $_POST["genero"];
        $edicao = $_POST["edicao"];
        $estado = $_POST["estado"];

        

        if (!( empty($id) | empty($ISBN) | empty($titulo) | empty($autor) | empty($editora) | empty($genero) | empty($edicao) | empty($estado))) {
            $id = intval($_POST["id"]);
            $ISBN = floatval($_POST["isbn"]);

            $stmt = $conn->prepare("UPDATE `livros` SET `ISBN`=?,`titulo`=?,`genero`=?,`autor`=?,`editora`=?,`edicao`=?,`estado`=? WHERE `ID` = ?");
            $stmt->bind_param('dssssssi', $ISBN, $titulo, $genero, $autor, $editora, $edicao, $estado, $id); // 's' specifies the variable type => 'string'
            
            
            $stmt->execute();
            header("Location: livros.php?page_no=$page_no");
            exit();

        }
    } else if (isset($_POST["editReq"])) {
        $id = $_POST["id"];
        $reqValue = $_POST["requisitavel"];
        
        

        if (isset($id)) {
            $id = intval($_POST["id"]);
            $reqValue = intval($_POST["requisitavel"]);

            $stmt = $conn->prepare("UPDATE `livros` SET `requisitavel`=? WHERE `ID`=?");
            $stmt->bind_param('ii', $reqValue, $id); // 's' specifies the variable type => 'string'
    
            $stmt->execute();

            
            header("Location: livros.php?page_no=$page_no");
            exit();
        }


    }  else if (isset($_POST["del"])) {
        $id = intval($_POST["id"]);
        if (!empty($id)) {
            $stmt = $conn->prepare('DELETE FROM `livros` WHERE `ID` = ?');
            $stmt->bind_param('i', $id); // 's' specifies the variable type => 'string'

            $stmt->execute();
            header("Location: livros.php?page_no=$page_no");
            exit();
        }
    }


    function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }
    header("Location: livros.php?page_no=$page_no");
    exit();
} else {
    header("Location: login.php");
    exit();
}
