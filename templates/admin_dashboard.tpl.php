<?php

declare(strict_types=1);

?>


<?php function output_header_admin($title, $session): void
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
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <script src="javascript/script.js" defer></script>
        <title><?= htmlspecialchars($title) ?></title>
    </head>

    <body>
        <header>
            <h1 id="logo"><a href="index.php">lancer</a></h1>
            <form class="search_bar" action="search.php" method="get">
                <input type="text" name="query" placeholder="Search...">
                <button class="fa fa-search" type="submit"></button>
            </form>
            <nav id="nav_menu">
                <button id="menu_toggle" class="fa fa-bars"></button>
                <ul>
                    <?php if ($session->getUser()) : ?>
                        <li><button onclick="window.location.href='add_service.php'">Add a service</button></li>
                        <li><button onclick="window.location.href='my_services.php'">Dashboard</button></li>
                    <?php endif; ?>
                    <?php if ($session->getUser()) drawLogoutForm($session);
                    else drawLoginForm(); ?>
                </ul>
            </nav>
        </header>
    <?php } ?>





    <?php function draw_dashboard_sidebar(): void
    { ?>
        <main id="freelancer_dashboard" class="dashboard-container">
            <aside class="dashboard-sidebar">
                <button class="dashboard-tab" onclick="window.location.href='my_services.php'">My Services</button>
                <button class="dashboard-tab" onclick="window.location.href='my_orders.php'">My Orders</button>
                <button class="dashboard-tab" onclick="window.location.href='admin_dashboard.php'">Admin Panel</button>
            </aside>
        <?php } ?>


        <?php function draw_admin_panel(array $users, array $categories, Session $session, $db): void
        { ?>
            <section class="dashboard-content">
                <h2>Admin Panel</h2>

                <div id="success_message" style="display: none;"></div>
                <div id="error_message" style="display: none;"></div>

                <!-- Promote/Demote users -->
                <section class="admin-section">
                    <h3>Manage Users</h3>
                    <table class="w3-table w3-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Promote</th>
                                <th>Demote</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <?php if ($user->id === $session->getUser()->id) continue; ?>
                                <tr>
                                    <td><?= htmlspecialchars($user->username) ?></td>
                                    <td><?= htmlspecialchars($user->email) ?></td>


                                    <td>
                                        <form action="actions/action.elevate_user.php" method="post">
                                            <input type="hidden" name="csrf" value="<?= $session->getCSRFToken() ?>">
                                            <input type="hidden" name="user_id" value="<?= $user->id ?>">
                                            <button class="elevate_user" type="submit">Elevate</button>
                                        </form>
                                    </td>

                                    <td>
                                        <form action="actions/action.demote_admin.php" method="post">
                                            <input type="hidden" name="csrf" value="<?= $session->getCSRFToken() ?>">
                                            <input type="hidden" name="user_id" value="<?= $user->id ?>">
                                            <button class="demote_user" type="submit">Demote</button>
                                        </form>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>

                <!-- add Category -->
                <section class="admin-section">
                    <h3>Add Category</h3>
                    <form action="actions/action.create_category.php" method="post">
                        <input type="text" name="category_name" placeholder="New category name" required>
                        <button class="add_category" type="submit">Add</button>
                    </form>
                </section>

                <!-- existing Categories -->
                <section class="admin-section">
                    <h3>Existing Categories</h3>
                    <ul>
                        <?php foreach ($categories as $category): ?>
                            <li><?= htmlspecialchars($category->name) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            </section>
        </main> <!-- close main opened in sidebar -->
    <?php } ?>