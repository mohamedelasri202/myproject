<?php

require 'reserveclass.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations Management - TravelEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .ocean-gradient {
            background: linear-gradient(135deg, #034694 0%, #00a7b3 100%);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-icon {
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .status-icon:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 ocean-gradient text-white py-8 px-6 fixed h-full">
            <div class="flex items-center mb-12">
                <i class="fas fa-compass text-3xl mr-3"></i>
                <span class="text-2xl font-bold tracking-wider">TravelEase</span>
            </div>
            
            <nav class="space-y-6">
                <a href="dashboord.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                    <i class="fas fa-th-large text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="users.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                    <i class="fas fa-users text-lg"></i>
                    <span class="font-medium">Clients</span>
                </a>
                <a href="reservations.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                    <i class="fas fa-calendar-check text-lg"></i>
                    <span class="font-medium">Reservations</span>
                </a>
                <a href="activities.php" class="flex items-center space-x-4 px-6 py-4 bg-white bg-opacity-10 rounded-xl">
                    <i class="fas fa-hiking text-lg"></i>
                    <span class="font-medium">Activities</span>
                </a>
                <a href="home.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                    <i class="fas fa-cog text-lg"></i>
                    <span class="font-medium">Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-72 p-8">
            <!-- Top Navigation -->
            <div class="flex justify-between items-center mb-12 bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="relative">
                        <input type="text" placeholder="Search activities..." 
                               class="pl-12 pr-4 py-3 bg-slate-50 rounded-xl w-72 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                        <i class="fas fa-search absolute left-4 top-4 text-slate-400"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <button class="relative p-2 bg-slate-50 rounded-xl hover:bg-slate-100 transition-all duration-300">
                            <i class="fas fa-bell text-slate-600 text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">3</span>
                        </button>
                    </div>
                    <!-- Admin Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center bg-slate-50 rounded-xl p-2 pr-4 hover:bg-slate-100 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center text-white font-bold mr-3">
                                TA
                            </div>
                            <span class="font-medium text-slate-700">Admin</span>
                            <i class="fas fa-chevron-down ml-3 text-slate-400 transition-transform group-hover:rotate-180"></i>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50">
                        <form action="logout.php" method="POST">
    <button type="submit" class="logout-btn">Logout</button>
</form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activities Table -->
            <!-- Reservations Table -->
        <div class="bg-white rounded-2xl shadow-sm">
            <div class="p-8 border-b border-slate-100">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-slate-800">Reservations Management</h2>
                </div>
            </div>
            <div class="overflow-x-auto p-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Client</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Activity</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Date</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Price</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Destination</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Status</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($reservations as $reservation): ?>
                            <tr class="hover:bg-slate-50 transition-all duration-300">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-slate-800"><?php echo htmlspecialchars($reservation['client_name']); ?></p>
                                        <p class="text-sm text-slate-500"><?php echo htmlspecialchars($reservation['client_email']); ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-slate-800"><?php echo htmlspecialchars($reservation['activity_name']); ?></p>
                                        <p class="text-sm text-slate-500"><?php echo htmlspecialchars($reservation['activity_description']); ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-slate-800"><?php echo date('M d, Y', strtotime($reservation['created_at'])); ?></p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-slate-800">$<?php echo number_format($reservation['total_price'], 2); ?></p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-slate-800"><?php echo htmlspecialchars($reservation['destination']); ?></p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-1">
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                            <button type="submit" name="update_status" value="pending" 
                                                class="status-icon text-yellow-600 hover:text-yellow-700 <?php echo $reservation['status'] === 'pending' ? 'active' : ''; ?>" 
                                                title="Pending">
                                                <i class="fas fa-clock"></i>
                                            </button>
                                            <button type="submit" name="update_status" value="confirmed" 
                                                class="status-icon text-green-600 hover:text-green-700 <?php echo $reservation['status'] === 'confirmed' ? 'active' : ''; ?>" 
                                                title="Confirmed">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="submit" name="update_status" value="cancelled" 
                                                class="status-icon text-red-600 hover:text-red-700 <?php echo $reservation['status'] === 'cancelled' ? 'active' : ''; ?>" 
                                                title="Canceled">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <a href="edit_reservation.php?id=<?php echo $reservation['id']; ?>" 
                                           class="text-blue-500 hover:text-blue-700" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                            <input type="hidden" name="delete_reservation" value="<?php echo $reservation['id']; ?>">
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
    // Add any JavaScript you need here
    document.addEventListener('DOMContentLoaded', function() {
        // Handle status updates
        const statusButtons = document.querySelectorAll('.status-icon');
        statusButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form');
                if (form) {
                    form.submit();
                }
            });
        });
    });
</script>

</body>
</html>