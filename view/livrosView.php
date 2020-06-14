<?php
    session_start();
    if (isset($_SESSION['user'])) { // Verifica se o user está autenticado
    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }
    ?>









<div class="wrapper">
    



<div>

   <!-- <form method="get">
        <div class="search-box">
            <input type="text" name="search" id="search" placeholder="Pesquisa">
            <button class="search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>



    </form>
-->
    <form  method="get">
    <table id="books">
    <thead>
        <tr>
            <th>ISBN</th>
            <th>Número</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Editora</th>
            <th>Gênero</th>
            <th>Edição</th>
            <th>Estado do livro</th>
            <th>Requisitavel</th>
        </tr>
</thead>
<tbody>

    <?php
        include 'model/dbh.php';

        	
        


       

        $total_records_per_page = 10;

        $offset = ($page_no-1) * $total_records_per_page;
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;
        $adjacents = "2";


        $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `livros`");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1; // total pages minus 1






        $rows = [];
        $sql = "SELECT ID, ISBN, num, titulo, genero, autor, editora, edicao, estado, requisitavel FROM livros ORDER BY ISBN ASC, num ASC LIMIT $offset, $total_records_per_page";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            // output data of each row
            
            $addBg = false;
            

            while($row = $result->fetch_assoc()) {
                $rows[$row['ID']] = $row;
                $check = "";


                if ($row['requisitavel'] == 1) {
                    $check = "checked";
                } else {
                    $check = "";
                }

                echo "<tr id='{$row['ID']}'>
                    <td>{$row['ISBN']}</td>
                    <td>{$row['num']}</td>
                    <td>{$row['titulo']}</td>
                    <td>{$row['autor']}</td>
                    <td>{$row['editora']}</td>
                    <td>{$row['genero']}</td>
                    <td>{$row['edicao']}</td>
                    <td>{$row['estado']}</td>
                    <td>
                    <label class='container'>
                        <input type='checkbox' id='reqValue' $check>
                        <span class='checkmark'></span>
                    </label> 
                </td></tr>";

                
            }

            
        } else {
            echo "0 results";
        }
        $conn->close();


    ?>
    </tbody>
            

    </table>
    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
        <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
    </div>
    <ul class="pagination">
        <?php if($page_no > 1){
        echo "<li><a href='?page_no=1'>First Page</a></li>";
        } ?>
        
        <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
        <a <?php if($page_no > 1){
        echo "href='?page_no=$previous_page'";
        } ?>>Previous</a>
        </li>

        <?php
            if ($total_no_of_pages <= 10){   
                for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                if ($counter == $page_no) {
                echo "<li class='active'><a>$counter</a></li>"; 
                        }else{
                       echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                               }
                       }
               } elseif ($total_no_of_pages > 10){
                    if($page_no <= 4) { 
                        for ($counter = 1; $counter < 8; $counter++){ 
                        if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>"; 
                        }else{
                                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                    }
                    }
                    echo "<li><a>...</a></li>";
                    echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                    echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    } elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
                        echo "<li><a href='?page_no=1'>1</a></li>";
                        echo "<li><a href='?page_no=2'>2</a></li>";
                        echo "<li><a>...</a></li>";
                        for (
                             $counter = $page_no - $adjacents;
                             $counter <= $page_no + $adjacents;
                             $counter++
                             ) {		
                             if ($counter == $page_no) {
                            echo "<li class='active'><a>$counter</a></li>";	
                            }else{
                                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                  }                  
                               }
                        echo "<li><a>...</a></li>";
                        echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                        echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    } else {
                        echo "<li><a href='?page_no=1'>1</a></li>";
                        echo "<li><a href='?page_no=2'>2</a></li>";
                        echo "<li><a>...</a></li>";
                        for (
                             $counter = $total_no_of_pages - 6;
                             $counter <= $total_no_of_pages;
                             $counter++
                             ) {
                             if ($counter == $page_no) {
                            echo "<li class='active'><a>$counter</a></li>";	
                            }else{
                                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                            }                   
                        }
                    }
                }
        ?>
        
        <li <?php if($page_no >= $total_no_of_pages){
        echo "class='disabled'";
        } ?>>
        <a <?php if($page_no < $total_no_of_pages) {
        echo "href='?page_no=$next_page'";
        } ?>>Next</a>
        </li>

        <?php if($page_no < $total_no_of_pages){
        echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
        } ?>
    </ul>
   
</form>





</div>

<div id="book-details">
        <form action="process.php" method="POST">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="requisitavel" name="requisitavel">
            <input type="hidden" id="page_no" name="page_no" value="<?php echo $page_no; ?>">

            <div class="horizontal">
                <div class="some-margin">
                    <label for="isbn">ISBN:</label><br>
                    <input type="text" minlength="13" maxlength="13" id="isbn" name="isbn"><br>
                </div>
                <div id="quantidade-wrapper">
                    <label for="quantidade">Quantidade:</label><br>
                    <input type="number" id="quantidade" name="quantidade" min="1"><br>
                </div>

                <div id="num-wrapper" class="hide">
                    <label for="num">Número:</label><br>
                    <input type="number" id="num" name="num" min="1"><br>
                </div>
            </div>

            <label for="titulo">Título:</label><br>
            <input type="text" id="titulo" name="titulo"><br>

            <label for="autor">Autor:</label><br>
            <input type="text" id="autor" name="autor"><br>

            <label for="editora">Editora:</label><br>
            <input type="text" id="editora" name="editora"><br>

            <label for="genero">Gênero:</label><br>
            <input type="text" id="genero" name="genero"><br>

            <label for="edicao">Edição:</label><br>
            <input type="text" id="edicao" name="edicao"><br>

            <label for="estado">Estado do livro:</label><br>
            <textarea name="estado" id="estado" wrap="off" cols="30" rows="10"></textarea>
            

            <button id="btnPost" name="add" type="submit">Adicionar</button>
            <button type="button" class="hide" id="btnLimpar">Limpar</button>
        </form>
    </div>
    <script>

        var rows = <?php echo json_encode($rows); ?>;

    </script>


        <script src="Assets/js/livros.js"></script>
</div>

<?php
    } else {
        header("Location: login.php");
        exit();
    }

?>