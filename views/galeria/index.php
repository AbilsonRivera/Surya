<style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    .carousel-container {
      width: 100%;
      overflow: hidden;
      border-radius: 0;
      padding: 0 !important;
    }
    
    .carousel-track {
      display: flex;
      animation: scroll 20s linear infinite;
    }

    .carousel-item {
      display: inline-block;
      width: 20vw; /* Ajusta el número de items visibles (25vw = 4 items por pantalla) */
      aspect-ratio: 1 / 1;
      background-size: cover;
      background-position: center;
      margin: 0; /* Sin espacio entre imágenes */
    }
    
    @keyframes scroll {
    0% {
      transform: translateX(0);
    }
    100% {
      transform: translateX(-18%);
    }
    }
    
    @media (max-width: 992px) {
      .carousel-item {
          width: 33vw;
        }
    }
    
    @media (max-width: 768px) {
      .carousel-item {
          width: 50vw;
        }
    }
    
    @media (max-width: 576px) {
      .carousel-item {
          width: 100vw;
        }
    }
    
</style>

<section class="services-section">
    <!-- Carrusel -->
    <div class="carousel-container">
        <div class="carousel-track">
          <?php foreach ($galerias as $foto): ?>
            <div class="carousel-item" style="background-image: url('./img/<?= htmlspecialchars($foto['archivo']) ?>');"></div>
          <?php endforeach; ?>
        </div>
    </div>
</section>

