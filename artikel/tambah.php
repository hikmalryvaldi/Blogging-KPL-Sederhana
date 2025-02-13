<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Artikel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
    }

    label {
      display: block;
      margin: 10px 0 5px;
    }

    input[type="text"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #5cb85c;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #4cae4c;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Tambah Artikel</h2>
    <form action="formhandler.inc.php" method="post" enctype="multipart/form-data">
      <label for="title">Judul Artikel:</label>
      <input type="text" name="title" required placeholder="Masukkan judul artikel...">

      <label for="author">Nama Penulis:</label>
      <input type="text" name="author" required placeholder="Masukkan nama penulis...">

      <label for="image">Unggah Gambar:</label>
      <input type="file" name="image" accept="image/*">

      <label for="content">Isi Artikel:</label>
      <textarea name="content" rows="5" required placeholder="Masukkan isi artikel..."></textarea>

      <button type="submit">Tambah Artikel</button>
    </form>
  </div>
</body>

</html>