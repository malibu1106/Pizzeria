<strong>bloc affiché si utilisateur connecté ET si utilisateur a effectué au moins une commande</strong><br>
<label for="order">Lier ma demande à une commande :</label>
<select name="order" id="order">
    <?php foreach ($user_orders as $user_order) {
                $total = $user_order['total'];
                $date_order_formatted = date('d/m/y H:i', strtotime($user_order['date_order']));

                // Format du total
                if (intval($total) == $total) {
                // Si le total est un entier (pas de décimales), afficher sans décimales
                $total_formatted = intval($total) . '€';
                } else {
                // Sinon, remplacer le point décimal par une virgule et afficher avec les décimales
                $total_formatted = str_replace('.', ',', $total) . '€';
                }

                echo '<option value=' . $user_order['order_id'] . '>';
                echo 'Commande n°' . $user_order['order_id'] . ' ' . $date_order_formatted . ' ' . $total_formatted; // Ajouter un espace entre l'heure et le total
                echo '</option>';
            }
?>

</select><br>
<label for="file">Joindre un fichier :</label>
<input type="file" name="attachment" id="attachment" accept=".jpg, .jpeg, .png, .gif, .pdf, .bmp" /><br>