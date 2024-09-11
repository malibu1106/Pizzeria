            <?php


                echo'
                <figure class="container-pizza-info">
                    <div class="position-relative">
                        <img class="img-pizza" src="' . htmlspecialchars($pizza['image_url']) . '" alt="pizza">
                        <span class="pizza-price ';
                        echo ($pizza['is_discounted'] !== 0.00) ? 'pizza-promo' : '';
                        
                        echo'">' . htmlspecialchars($pizza['price']) . '€</span>
                    </div>
                    <figcaption class="pizza-descritpion">
                        <p class="title-pizza">' . htmlspecialchars($pizza['name']) . '</p>
                        <p class="description-pizza">' . htmlspecialchars($pizza['description']) . '</p>
                        <a class="btn-commander" href="">Commander</a>
                    </figcaption>
                </figure>';


            ?>