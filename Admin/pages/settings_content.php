<?php
include('../config/db.php');
// session_start();

$settings_query = mysqli_query($conn, "SELECT * FROM page_settings LIMIT 1");
if (mysqli_num_rows($settings_query) == 0) {
    mysqli_query($conn, "INSERT INTO page_settings (site_title, site_logo, favicon, browse_lock, disable_copy_paste, one_tab_enforcement, full_summary, short_summary) 
                        VALUES ('My LMS', 'default_logo.png', 'default_favicon.png', 0,0,0,0,0)");
    $settings_query = mysqli_query($conn, "SELECT * FROM page_settings LIMIT 1");
}
$settings = mysqli_fetch_assoc($settings_query);

if (isset($_POST['save_settings'])) {
    $site_title = mysqli_real_escape_string($conn, $_POST['site_title']);

    $site_logo = $settings['site_logo'];
    $favicon = $settings['favicon'];

    if (!empty($_FILES['site_logo']['name'])) {
        $logo_name = time() . '_' . basename($_FILES['site_logo']['name']);
        $target_logo = "../uploads/profile/" . $logo_name;
        move_uploaded_file($_FILES['site_logo']['tmp_name'], $target_logo);
        $site_logo = $logo_name;
    }

    if (!empty($_FILES['favicon']['name'])) {
        $favicon_name = time() . '_' . basename($_FILES['favicon']['name']);
        $target_favicon = "../uploads/profile/" . $favicon_name;
        move_uploaded_file($_FILES['favicon']['tmp_name'], $target_favicon);
        $favicon = $favicon_name;
    }

    function checkBox($key) { return isset($_POST[$key]) ? 1 : 0; }

    $update_query = "UPDATE page_settings SET 
        site_title='$site_title',
        site_logo='$site_logo',
        favicon='$favicon',
        browse_lock=" . checkBox('browse_lock') . ",
        disable_copy_paste=" . checkBox('disable_copy_paste') . ",
        one_tab_enforcement=" . checkBox('one_tab_enforcement') . ",
        full_summary=" . checkBox('full_summary') . ",
        short_summary=" . checkBox('short_summary') . "
        WHERE id=" . $settings['id'];

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Settings updated successfully!'); window.location.href='Settings.php';</script>";
    } else {
        echo "<script>alert('Error updating settings!');</script>";
    }
}
?>

<div class="container-fluid">
<form method="POST" enctype="multipart/form-data">

<!-- Site Title & Favicon -->
<div class="card card-info mb-4">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-globe"></i> Site Title & Favicon</h3></div>
    <div class="card-body">
        <div class="form-group">
            <label>Site Title</label>
            <input type="text" name="site_title" class="form-control" value="<?= htmlspecialchars($settings['site_title']) ?>" required>
        </div>
        <div class="form-group">
            <label>Favicon</label>
            <input type="file" name="favicon" accept="image/*">
            <small>Current:</small>
            <img src="../uploads/profile/<?= $settings['favicon'] ?>" height="30">
        </div>
        <div class="form-group">
            <label>Site Logo</label>
            <input type="file" name="site_logo" accept="image/*">
            <small>Current:</small>
            <img src="../uploads/profile/<?= $settings['site_logo'] ?>" height="40">
        </div>
    </div>
</div>

<!-- Security & Features -->
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-shield-alt"></i> Security Features</h3></div>
    <div class="card-body">
        <div class="form-group d-flex justify-content-between align-items-center">
            <label>Browser Lock</label>
            <input type="checkbox" name="browse_lock" <?= $settings['browse_lock'] ? 'checked' : '' ?>>
        </div>
        <div class="form-group d-flex justify-content-between align-items-center">
            <label>Disable Copy-Paste & Right-Click</label>
            <input type="checkbox" name="disable_copy_paste" <?= $settings['disable_copy_paste'] ? 'checked' : '' ?>>
        </div>
        <div class="form-group d-flex justify-content-between align-items-center">
            <label>One Tab Enforcement</label>
            <input type="checkbox" name="one_tab_enforcement" <?= $settings['one_tab_enforcement'] ? 'checked' : '' ?>>
        </div>
        <div class="form-group d-flex justify-content-between align-items-center">
            <label>Full Summary</label>
            <input type="checkbox" name="full_summary" <?= $settings['full_summary'] ? 'checked' : '' ?>>
        </div>
        <div class="form-group d-flex justify-content-between align-items-center">
            <label>Short Summary</label>
            <input type="checkbox" name="short_summary" <?= $settings['short_summary'] ? 'checked' : '' ?>>
        </div>
    </div>
    <div class="card-footer text-right">
        <button type="submit" name="save_settings" class="btn btn-custom"><i class="fas fa-save"></i> Save Settings</button>
    </div>
</div>
</form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.title = "<?= htmlspecialchars($settings['site_title']) ?>";
    let link = document.querySelector("link[rel~='icon']");
    if (!link) { link = document.createElement('link'); link.rel='icon'; document.head.appendChild(link); }
    link.href = "../uploads/profile/<?= $settings['favicon'] ?>";
});
</script>
