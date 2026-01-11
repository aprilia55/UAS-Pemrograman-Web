<?php
session_start();
include "../config/database.php";

/* =======================
   AUTH CHECK
======================= */
if (!isset($_SESSION['login'])) {
    header("Location: /lets_cook/index.php");
    exit;
}

/* =======================
   INPUT (SEARCH & CATEGORY)
======================= */
$keyword  = isset($_GET['search']) ? trim($_GET['search']) : "";
$category = isset($_GET['category']) ? trim($_GET['category']) : "";

/* =======================
   PAGINATION SETUP
======================= */
$limit = 4; // jumlah resep per halaman
$page  = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = max(1, $page);

/* =======================
   WHERE CONDITION (DINAMIS)
======================= */
$where = "WHERE title LIKE '%$keyword%'";
if ($category !== "") {
    $where .= " AND category = '$category'";
}

/* =======================
   TOTAL DATA
======================= */
$countQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM recipes $where"
);
$totalData = mysqli_fetch_assoc($countQuery)['total'];
$totalPage = max(1, ceil($totalData / $limit));

if ($page > $totalPage) $page = 1;
$start = ($page - 1) * $limit;

/* =======================
   DATA PER PAGE
======================= */
$query = mysqli_query(
    $conn,
    "SELECT * FROM recipes
     $where
     ORDER BY created_at DESC
     LIMIT $start, $limit"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard - Let's Cook</title>

<style>
* { box-sizing: border-box; font-family: Arial, sans-serif; }
body { margin: 0; display: flex; background: #fafafa; min-height: 100vh; }

/* SIDEBAR */
.sidebar {
    width: 240px;
    height: 100vh;
    background: #ffffff;
    border-right: 1px solid #ddd;
    padding: 20px;
    position: fixed;
}
.sidebar h2 { color: #ff6f00; text-align: center; margin-bottom: 30px; }
.sidebar a {
    display: block;
    text-decoration: none;
    color: #333;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 10px;
    font-weight: bold;
}
.sidebar a:hover { background: #ffe0b2; }

/* CONTENT */
.content {
    margin-left: 240px;
    flex: 1;
    padding: 40px;
}

/* HEADER */
.header { text-align: center; margin-bottom: 40px; }
.header h1 { color: #ff6f00; font-size: 32px; margin-bottom: 5px; }
.header p { color: #555; margin-bottom: 20px; }

/* SEARCH */
.search-box {
    display: flex;
    justify-content: center;
    gap: 10px;
}
.search-box input,
.search-box select {
    padding: 14px;
    border-radius: 30px;
    border: 1px solid #ccc;
}
.search-box input { width: 260px; }
.search-box button {
    padding: 14px 30px;
    border-radius: 30px;
    border: none;
    background: #ff6f00;
    color: white;
    cursor: pointer;
}

/* GRID */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 25px;
}
.card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,.15);
    transition: transform .2s;
}
.card:hover { transform: translateY(-5px); }
.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.card .info { padding: 18px; }
.card h4 { margin: 0 0 5px; }
.card small { color: gray; }

.favorite {
    display: inline-block;
    margin-top: 10px;
    color: #ff6f00;
    font-weight: bold;
    text-decoration: none;
}

/* PAGINATION */
.pagination {
    margin-top: 40px;
    text-align: center;
}
.pagination a {
    display: inline-block;
    padding: 10px 16px;
    margin: 0 4px;
    border-radius: 8px;
    background: #eee;
    text-decoration: none;
    color: #333;
    font-weight: bold;
}
.pagination a.active,
.pagination a:hover {
    background: #ff6f00;
    color: white;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🍳 Let's Cook</h2>
    <a href="index.php">🏠 Dashboard</a>
    <a href="favorites.php">⭐ Favorit</a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="admin/index.php">👑 Admin Panel</a>
    <?php endif; ?>

    <a href="/lets_cook/auth/logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

<div class="header">
    <h1>Let's Cook 🍳</h1>
    <p>Mau masak apa hari ini?</p>

    <form method="GET" class="search-box">
        <input type="hidden" name="page" value="1">

        <input type="text" name="search"
               placeholder="Cari resep..."
               value="<?= htmlspecialchars($keyword); ?>">

        <select name="category">
            <option value="">Semua Kategori</option>
            <option value="Makanan" <?= $category=='Makanan'?'selected':''; ?>>Makanan</option>
            <option value="Minuman" <?= $category=='Minuman'?'selected':''; ?>>Minuman</option>
            <option value="Dessert" <?= $category=='Dessert'?'selected':''; ?>>Dessert</option>
        </select>

        <button type="submit">Cari</button>
    </form>
</div>

<div class="grid">
<?php if (mysqli_num_rows($query) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($query)): ?>
    <div class="card">
        <a href="detail_recipe.php?id=<?= $row['id']; ?>" style="text-decoration:none;color:inherit;">
            <img src="../uploads/<?= $row['image'] ?: 'default.jpeg'; ?>">
            <div class="info">
                <h4><?= htmlspecialchars($row['title']); ?></h4>
                <small><?= htmlspecialchars($row['category']); ?></small>
            </div>
        </a>
        <div class="info">
            <a href="add_favorite.php?id=<?= $row['id']; ?>" class="favorite">❤️ Favorite</a>
        </div>
    </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Resep tidak ditemukan 😢</p>
<?php endif; ?>
</div>

<?php if ($totalPage > 1): ?>
<div class="pagination">
<?php for ($i = 1; $i <= $totalPage; $i++): ?>
    <a href="?page=<?= $i ?>&search=<?= urlencode($keyword); ?>&category=<?= urlencode($category); ?>"
       class="<?= $i == $page ? 'active' : '' ?>">
       <?= $i ?>
    </a>
<?php endfor; ?>
</div>
<?php endif; ?>

</div>
</body>
</html>
