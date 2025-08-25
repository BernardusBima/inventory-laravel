<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('barang.index') }}">
          <i class="bi bi-box-seam-fill"></i>
          Inventaris Pro
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('barang.index') }}">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Laporan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pengaturan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>