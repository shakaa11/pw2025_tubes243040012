<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$message = '';
$message_type = '';

$upload_dir = '../assets/images/destinations/'; 


// Handle Add/Edit Destination
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi dan validasi semua data POST yang masuk
    $destination_id = filter_input(INPUT_POST, 'destination_id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name');
    $location = filter_input(INPUT_POST, 'location');
    $description = filter_input(INPUT_POST, 'description');
   
    $price_estimate = filter_input(INPUT_POST, 'price_estimate', FILTER_VALIDATE_FLOAT);
    $best_time_to_visit = filter_input(INPUT_POST, 'best_time_to_visit');

    $image_filename = ''; 

    // Menangani unggahan file
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            // Hasilkan nama file yang unik untuk mencegah penimpaan
            $new_file_name = uniqid('img_', true) . '.' . $file_ext;
            $upload_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp_name, $upload_path)) {
                $image_filename = $new_file_name;
            } else {
                $message = 'Error uploading image file.';
                $message_type = 'danger';
            }
        } else {
            $message = 'Invalid image file type. Only JPG, JPEG, PNG, GIF are allowed.';
            $message_type = 'danger';
        }
    } else {
        //Jika tidak ada file baru yang diunggah, pertahankan nama file gambar yang ada untuk pembaruan
        if (!empty($destination_id)) {
            $stmt_old_image = $pdo->prepare("SELECT image FROM destinations WHERE id = ?");
            $stmt_old_image->execute([$destination_id]);
            $old_image = $stmt_old_image->fetchColumn();
            $image_filename = $old_image; 
        }
       
    }


    // Validasi dasar untuk memastikan bidang yang diperlukan tidak kosong
    if (empty($name) || empty($location) || empty($description) || empty($image_filename)) {
        $message = 'Please fill in all required fields (Name, Location, Description) and upload an image.';
        $message_type = 'danger';
    } else {
        if (!empty($destination_id)) {
            // Perbarui tujuan yang ada
            $stmt = $pdo->prepare("UPDATE destinations SET name = ?, location = ?, description = ?, image = ?, price_estimate = ?, best_time_to_visit = ? WHERE id = ?");
            if ($stmt->execute([$name, $location, $description, $image_filename, $price_estimate, $best_time_to_visit, $destination_id])) {
                $message = 'Destination updated successfully!';
                $message_type = 'success';
            } else {
                $message = 'Error updating destination.';
                $message_type = 'danger';
            }
        } else {
            // Tambahkan tujuan baru
            $stmt = $pdo->prepare("INSERT INTO destinations (name, location, description, image, price_estimate, best_time_to_visit) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $location, $description, $image_filename, $price_estimate, $best_time_to_visit])) {
                $message = 'Destination added successfully!';
                $message_type = 'success';
            } else {
                $message = 'Error adding destination.';
                $message_type = 'danger';
            }
        }
    }
}

// Handle Delete Destination (Pastikan juga menghapus file gambar fisik)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_to_delete = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id_to_delete)) {
        // Get the image filename before deleting the record
        $stmt_get_image = $pdo->prepare("SELECT image FROM destinations WHERE id = ?");
        $stmt_get_image->execute([$id_to_delete]);
        $image_to_delete = $stmt_get_image->fetchColumn();

        $stmt = $pdo->prepare("DELETE FROM destinations WHERE id = ?");
        if ($stmt->execute([$id_to_delete])) {
            // Delete the physical file
            if ($image_to_delete && file_exists($upload_dir . $image_to_delete)) {
                unlink($upload_dir . $image_to_delete);
            }
            $message = 'Destination deleted successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error deleting destination.';
            $message_type = 'danger';
        }
    } else {
        $message = 'Invalid destination ID for deletion.';
        $message_type = 'danger';
    }
}

// Fetch all destinations
$stmt = $pdo->query("SELECT * FROM destinations ORDER BY name ASC");
$destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<main class="container my-5">
    <h1 class="futuristic-section-title">Manage Destinations</h1>
    <a href="dashboard.php" class="btn btn-outline-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="futuristic-card p-4 mb-4">
        <h3 class="text-primary"><?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ? 'Edit Destination' : 'Add New Destination'; ?></h3>
        <?php
        $edit_destination = [
            'id' => '',
            'name' => '',
            'location' => '',
            'description' => '',
            'image' => '', 
            'price_estimate' => '',
            'best_time_to_visit' => ''
        ];

        if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
            $id_to_edit = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            if (!empty($id_to_edit)) {
                $stmt_edit = $pdo->prepare("SELECT * FROM destinations WHERE id = ?");
                $stmt_edit->execute([$id_to_edit]);
                $fetched_destination = $stmt_edit->fetch(PDO::FETCH_ASSOC);
                if ($fetched_destination) {
                    $edit_destination = $fetched_destination;
                } else {
                    $message = 'Destination not found for editing.';
                    $message_type = 'danger';
                }
            } else {
                $message = 'Invalid destination ID for editing.';
                $message_type = 'danger';
            }
        }
        ?>
        <form action="manage_destinations.php" method="POST" enctype="multipart/form-data"> <input type="hidden" name="destination_id" value="<?php echo htmlspecialchars($edit_destination['id']); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Destination Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($edit_destination['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($edit_destination['location']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($edit_destination['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image" <?php echo empty($edit_destination['id']) ? 'required' : ''; ?>>
                <?php if (!empty($edit_destination['image'])): ?>
                    <small class="form-text text-white-50">Current Image: <a href="<?php echo htmlspecialchars($upload_dir . $edit_destination['image']); ?>" target="_blank"><?php echo htmlspecialchars($edit_destination['image']); ?></a> (Upload new to replace)</small>
                    <img src="<?php echo htmlspecialchars($upload_dir . $edit_destination['image']); ?>" alt="Current Image" style="width: 100px; height: 60px; object-fit: cover; margin-top: 5px;">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="price_estimate" class="form-label">Price Estimate (Optional, Rp)</label>
                <input type="number" step="0.01" class="form-control" id="price_estimate" name="price_estimate" value="<?php echo htmlspecialchars($edit_destination['price_estimate']); ?>">
            </div>
            <div class="mb-3">
                <label for="best_time_to_visit" class="form-label">Best Time to Visit (Optional)</label>
                <input type="text" class="form-control" id="best_time_to_visit" name="best_time_to_visit" value="<?php echo htmlspecialchars($edit_destination['best_time_to_visit']); ?>">
            </div>
            <button type="submit" class="btn futuristic-button"><?php echo !empty($edit_destination['id']) ? 'Update Destination' : 'Add Destination'; ?></button>
            <?php if (!empty($edit_destination['id'])): ?>
                <a href="manage_destinations.php" class="btn btn-outline-secondary ms-2">Cancel Edit</a>
            <?php endif; ?>
        </form>
    </div>

    <h3 class="text-primary mt-5">Existing Destinations</h3>
    <div class="table-responsive futuristic-card p-3">
        <table class="table table-dark table-hover text-white-50">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($destinations)): ?>
                    <?php foreach ($destinations as $dest): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dest['id']); ?></td>
                            <td><?php echo htmlspecialchars($dest['name']); ?></td>
                            <td><?php echo htmlspecialchars($dest['location']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($upload_dir . $dest['image']); ?>" alt="<?php echo htmlspecialchars($dest['name']); ?>" style="width: 80px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                            <td>
                                <a href="manage_destinations.php?action=edit&id=<?php echo htmlspecialchars($dest['id']); ?>" class="btn btn-info btn-sm me-2"><i class="fas fa-edit"></i> Edit</a>
                                <a href="manage_destinations.php?action=delete&id=<?php echo htmlspecialchars($dest['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this destination?');"><i class="fas fa-trash-alt"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No destinations found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../includes/footer.php'; ?>