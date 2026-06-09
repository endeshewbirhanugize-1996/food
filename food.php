<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>🍕 FoodieDash | Delicious Food Delivery</title>
    <!-- Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <header class="main-header">
            <div class="logo-area">
                <i class="fas fa-utensils"></i>
                <h1>FoodieDash</h1>
            </div>
            <div class="cart-icon-mobile" id="mobileCartToggle">
                <i class="fas fa-shopping-basket"></i>
                <span class="cart-count-badge" id="cartCountBadge">0</span>
            </div>
        </header>

        <div class="dashboard">
            <!-- Menu Section (Left / Main) -->
            <main class="menu-grid-section">
                <h2><i class="fas fa-fire"></i> Today's Specials</h2>
                <div class="menu-grid" id="menuGrid">
                    <!-- Items will be injected via PHP + JS hybrid, but we render with PHP for initial load -->
                    <?php
                    // PHP block to display menu items from database
                    session_start();
                    require_once 'db_config.php';
                    $menuQuery = "SELECT id, name, description, price, category, image_url FROM menu ORDER BY category, id";
                    $result = $conn->query($menuQuery);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $img = !empty($row['image_url']) ? $row['image_url'] : 'https://via.placeholder.com/200x150?text=Yummy';
                            echo '<div class="food-card" data-id="' . $row['id'] . '">
                                    <div class="card-img" style="background-image: url(\'' . htmlspecialchars($img) . '\');"></div>
                                    <div class="card-body">
                                        <h3>' . htmlspecialchars($row['name']) . '</h3>
                                        <p class="desc">' . htmlspecialchars($row['description']) . '</p>
                                        <div class="price-row">
                                            <span class="price">$' . number_format($row['price'], 2) . '</span>
                                            <span class="category-badge">' . htmlspecialchars($row['category']) . '</span>
                                        </div>
                                        <button class="add-to-cart-btn" data-id="' . $row['id'] . '">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo '<p class="no-items">Menu loading failed, please check database connection.</p>';
                    }
                    ?>
                </div>
            </main>

            <!-- Cart Sidebar (Right Panel) -->
            <aside class="cart-sidebar" id="cartSidebar">
                <div class="cart-header">
                    <h3><i class="fas fa-shopping-cart"></i> Your Cart</h3>
                    <button id="closeCartSidebar" class="close-cart-btn"><i class="fas fa-times"></i></button>
                </div>
                <div class="cart-items-container" id="cartItemsList">
                    <!-- dynamic cart items loaded via JS -->
                    <div class="empty-cart-msg">Your cart is empty 🛒<br>Add some delicious food!</div>
                </div>
                <div class="cart-summary">
                    <div class="total-row">
                        <span>Total:</span>
                        <span id="cartTotalPrice">$0.00</span>
                    </div>
                </div>
                <div class="checkout-form" id="checkoutForm">
                    <h4>Delivery Details</h4>
                    <input type="text" id="customerName" placeholder="Full Name" required>
                    <input type="tel" id="customerPhone" placeholder="Phone Number" required>
                    <textarea id="customerAddress" rows="2" placeholder="Full Delivery Address" required></textarea>
                    <button id="placeOrderBtn" class="place-order-btn"><i class="fas fa-check-circle"></i> Place Order</button>
                    <div id="orderMessage" class="order-message"></div>
                </div>
            </aside>
        </div>
        <footer class="footer">
            <p>© 2025 FoodieDash — Delivered with ❤️</p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>