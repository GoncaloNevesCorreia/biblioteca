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
        $sql = "SELECT ID, ISBN, num, titulo, genero, autor, editora, edicao, estado FROM livros where requisitavel = 1 and requisitado = 0 ORDER BY ISBN ASC, num ASC LIMIT $offset, $total_records_per_page";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            // output data of each row
            
            $addBg = false;
            

            while($row = $result->fetch_assoc()) {
                $rows[$row['ID']] = $row;


               

                echo "<tr id='{$row['ID']}'>
                    <td>{$row['ISBN']}</td>
                    <td>{$row['num']}</td>
                    <td>{$row['titulo']}</td>
                    <td>{$row['autor']}</td>
                    <td>{$row['editora']}</td>
                    <td>{$row['genero']}</td>
                    <td>{$row['edicao']}</td>
                    <td>{$row['estado']}</td>
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