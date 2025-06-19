<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Coming Soon</title>
  <!-- Fuente Lato (opcional) -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
  
  <style>
    /* 
      Estilos base para body: 
      - Imagen de fondo que cubre toda la pantalla (cover)
      - Sin márgenes
      - Altura completa (100vh)
    */
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: url("img/comig.jpg") no-repeat center center fixed; /* Ajustar ruta */
      background-size: cover;
      font-family: 'Lato', sans-serif;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    /* Contenedor principal que centra todos los elementos */
    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Logo centrado y con un margen inferior */
    .logo {
      width: 550px; /* Ajusta según tu gusto */
      margin-bottom: 20px;
    }

    /* Contenedor del countdown */
    .countdown {
      display: flex;
      flex-wrap: wrap; 
      justify-content: center;
      gap: 15px; 
      margin-bottom: 50px;
    }
    
    /*
      Cada item del countdown (número + label)
      Flex en columna y centrado
    */
    .time-item {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Caja circular que muestra el número */
    .time-box {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      padding: 10px;
      border: 2px solid #000;
      border-radius: 50%;
      background-color: rgba(255,255,255,0.2);
      /* Puedes ajustar el fondo para que destaque más o menos */
    }

    /* Número grande dentro de la caja */
    .time-number {
      font-size: 1.7rem;
      font-weight: 700;
      color: #000; /* Si deseas el número en negro, ajusta a tu gusto */
    }

    /* Texto (Días, Horas, Min, Seg) debajo de la caja */
    .time-label {
      margin-top: 5px;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #000; /* Ajusta color si lo prefieres blanco, etc. */
    }

    /* Responsive: en pantallas muy pequeñas */
    @media (max-width: 480px) {
      .logo {
        width: 320px;
      }
      .time-box {
        width: 40px;
        height: 40px;
      }
      .time-number {
        font-size: 1.2rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <!-- Logo en el centro -->
    <img src="img/logo-comig.png" alt="Logo" class="logo" />

    <!-- Contador de tiempo -->
    <div class="countdown">
      <!-- DAYS -->
      <div class="time-item">
        <div class="time-box">
          <div class="time-number" id="days">00</div>
        </div>
        <div class="time-label">Días</div>
      </div>
      <!-- HOURS -->
      <div class="time-item">
        <div class="time-box">
          <div class="time-number" id="hours">00</div>
        </div>
        <div class="time-label">Horas</div>
      </div>
      <!-- MINUTES -->
      <div class="time-item">
        <div class="time-box">
          <div class="time-number" id="minutes">00</div>
        </div>
        <div class="time-label">Min</div>
      </div>
      <!-- SECONDS -->
      <div class="time-item">
        <div class="time-box">
          <div class="time-number" id="seconds">00</div>
        </div>
        <div class="time-label">Seg</div>
      </div>
    </div>
  </div>

  <!-- Script del contador regresivo -->
 

</body>
</html>
