            <?php
            echo '<div class="pizza">';
            echo '<strong>' . htmlspecialchars($pizza['name']) . '</strong><br>';
            echo 'Description: ' . htmlspecialchars($pizza['description']) . '<br>';
            echo 'Prix: ' . htmlspecialchars($pizza['price']) . '€<br>';
            echo '</div>';
            ?>