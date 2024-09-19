<form action="orders.php" method="GET" class="mb-4 w-50 mx-auto">
    <div class="form-check d-flex justify-content-around align-items-center">
        Filtrer par date :
        <input type="date" name="order_date" id="order_date" class="form-control w-25"
            value="<?= isset($_GET['order_date']) ? htmlspecialchars($_GET['order_date']) : date('Y-m-d') ?>">
    </div>
    <!-- Conserver l'état actuel de order_display -->
    <input type="hidden" name="order_display" value="<?= htmlspecialchars($orderDisplay) ?>">
</form>

terminees.php