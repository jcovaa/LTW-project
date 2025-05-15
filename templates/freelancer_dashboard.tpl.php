<?php

declare(strict_types=1);

?>


<?php function output_header($title, $session): void
{ ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/freelancer_dashboard.css">
        <script src="javascript/script.js" defer></script>
        <title>My Web Page</title>
    </head>

    <body>
        <header>
            <h1 id="logo"><a href="index.php">Title</a></h1>
            <form class="search_bar" action="search.php" method="get">
                <input type="text" name="query" placeholder="Search...">
                <button class="fa fa-search" type="submit"></button>
            </form>
            <nav id="nav_menu">
                <ul>
                    <?php if ($session->getUser()) : ?>
                        <li><button onclick="window.location.href='add_service.php'">Add a service</button></li>
                        <li><button onclick="window.location.href='freelancer_dashboard.php'">Dashboard</button>
                        <?php endif; ?>
                        <?php if ($session->getUser()) drawLogoutForm($session);
                        else drawLoginForm(); ?>
                </ul>
            </nav>
        </header>
    <?php } ?>



    <?php function drawLogoutForm($session)
    { ?>
        <li><a href="profile.php"><?= htmlspecialchars($session->getUser()->username) ?></a></li>
        <li>
            <form action="../actions/action.logout.php" method="post" style="display: inline;">
                <button type="submit">Logout</button>
            </form>
        </li>
    <?php } ?>

    <?php function drawLoginForm()
    { ?>
        <li><button onclick="window.location.href='login.php'">Login</button></li>
        <li><button onclick="window.location.href='register.php'">Sign Up</button></li>
    <?php } ?>


    <?php function draw_dashboard_sidebar(): void
    { ?>
        <main id="freelancer_dashboard" class="dashboard-container">
            <aside class="dashboard-sidebar">
                <button class="dashboard-tab" onclick="window.location.href='my_services.php'">My Services</button>
                <button class="dashboard-tab" onclick="window.location.href='my_orders.php'">My Orders</button>
            </aside>
        <?php } ?>



        <?php function draw_services_section(array $services): void
        { ?>
            <section class="dashboard-content">
                <div id="services" class="dashboard-tab-content" style="display: block;">
                    <h2>My Services</h2>
                    <?php if (empty($services)): ?>
                        <p>You haven't listed any services yet.</p>
                    <?php else: ?>
                        <?php foreach ($services as $service): ?>
                            <div class="service-card" id="service-<?= $service->id ?>">
                                <!-- view mode -->
                                <div class="view-mode">
                                    <div class="view-content">
                                        <div>
                                            <h3><?= htmlspecialchars($service->name) ?></h3>
                                            <p><?= htmlspecialchars($service->description) ?></p>
                                            <p><?= $service->avgRating ?></p>
                                            <p><strong>Price:</strong> €<?= number_format($service->price, 2) ?></p>
                                            <p><strong>Delivery Time:</strong> <?= $service->deliveryTime ?> days</p>
                                        </div>
                                        <img id="actualImage<?= $service->id ?>" src="<?= htmlspecialchars($service->imageUrl) ?>">
                                    </div>
                                    <div class="service-actions">
                                        <div class="left-buttons">
                                            <button class="button edit" onclick="toggleEdit(<?= $service->id ?>)">Edit</button>
                                            <form action="actions/action.delete_service.php" method="post" onsubmit="return confirm('Are you sure you want to delete this service?');" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $service->id ?>">
                                                <button type="submit" class="button danger">Delete</button>
                                            </form>
                                        </div>
                                        <button onclick="window.location.href='service_orders.php?service_id=<?= $service->id ?>'" class="button expand">Customer Orders</button>
                                    </div>
                                </div>

                                <!-- edit mode -->
                                <form class="edit-mode" action="actions/action.edit_service.php" method="post" enctype="multipart/form-data" style="display: none;">
                                    <input type="hidden" name="id" value="<?= $service->id ?>">
                                    <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($service->name) ?>" required></label><br>
                                    <label>Description: <textarea name="description"><?= htmlspecialchars($service->description) ?></textarea></label><br>
                                    <label>Price (€): <input type="number" name="price" step="0.01" value="<?= $service->price ?>" required></label><br>
                                    <label>Delivery Time (days): <input type="number" name="deliveryTime" value="<?= $service->deliveryTime ?>" required></label><br>
                                    <div class="addImg">
                                        <img id="prevImage<?= $service->id ?>" src="<?= htmlspecialchars($service->imageUrl) ?>" data-original-src="<?= htmlspecialchars($service->imageUrl) ?>">
                                        <div class="input_image">
                                            <input type="file" id="image<?= $service->id ?>" name="image" accept=".jpeg,.jpg,.png">
                                        </div>
                                    </div>
                                    <button type="submit">Save</button>
                                    <button type="button" onclick="toggleCancel(<?= $service->id ?>)">Cancel</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    <?php } ?>



    <?php function draw_orders_section($orders): void
    { ?>
        <section class="dashboard-content">
            <h2>My Orders</h2>

            <?php if (empty($orders)): ?>
                <p>No orders made yet.</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-info">
                            <h3><?= htmlspecialchars($order->serviceName) ?></h3>
                            <p><strong>Freelancer:</strong> <?= $order->freelancerName ?></p>
                            <p><strong>Ordered On:</strong> <?= htmlspecialchars($order->orderDate) ?></p>
                            <p><strong>Status:</strong> <?= htmlspecialchars($order->status) ?></p>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        </main>
    <?php } ?>






    <?php function draw_service_orders($service, $orders): void
    { ?>
        <section class="dashboard-content">
            <h2>Orders for Service: <?= htmlspecialchars($service->name) ?></h2>

            <?php if (empty($orders)): ?>
                <p>No orders for this service yet.</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-info">
                            <p><strong>Customer:</strong> <?= $order->clientName ?></p>
                            <p><strong>Ordered On:</strong> <?= htmlspecialchars($order->orderDate) ?></p>
                            <p><strong>Status:</strong> <?= htmlspecialchars($order->status) ?></p>
                        </div>

                        <?php if ($order->status === 'pending'): ?>
                            <!-- Freelancer can mark as in progress -->
                            <form method="POST" action="actions/action.change_order_status.php">
                                <input type="hidden" name="order_id" value="<?= $order->orderId ?>">
                                <input type="hidden" name="new_status" value="in_progress">
                                <button type="submit">Start Order</button>
                            </form>
                        <?php elseif ($order->status === 'in_progress'): ?>
                            <form method="POST" action="actions/action.change_order_status.php">
                                <input type="hidden" name="order_id" value="<?= $order->orderId ?>">
                                <input type="hidden" name="new_status" value="complete">
                                <button type="submit">Mark as Complete</button>
                            </form>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        </main>


    <?php } ?>





    <?php function output_footer(): void
    { ?>
        <footer>
            <p>Name of the app</p>
            <p>name, date</p>
        </footer>
    </body>

    </html>
<?php } ?>