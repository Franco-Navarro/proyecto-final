<?php
    include("../../scriptsPHP/manejoSesion.inc");
    require '../../scriptsPHP/conexion.inc';

    $nivel = $_SESSION['nivel'];
    $id_usuario = $_SESSION['idUsuario'];
    $fechaPrimerPago = date("Y-m-d");

    $mensaje = '';

    if(isset($_POST["suscripcion-premium"])){
        if($nivel == 'premium'){
            $mensaje = 'Usted ya es premium';
        }else{
            $dias_disponibles = 30;

            $actualizo_usuario = mysqli_query($conexion, "UPDATE usuarios SET fk_rol = 3, tema_oscuro = 1 WHERE id_usuario = '$id_usuario'");
            
            $pago = mysqli_query($conexion, "INSERT INTO facturas (fecha_pago, importe, fk_usuario, primera_cuota) VALUES ('$fechaPrimerPago', 500, '$id_usuario', 1)");

            $query = mysqli_query($conexion, "SELECT * FROM dias WHERE fk_usuario = '$id_usuario'");

            if(!$query){
                $pago = mysqli_query($conexion, "INSERT INTO dias (fk_usuario, dias_disponibles) VALUES ('$id_usuario', 30)");
            }
            else{
                $actualizo_dias = mysqli_query($conexion, "UPDATE dias SET dias_disponibles='$dias_disponibles' WHERE fk_usuario = '$id_usuario'");
            }            

            echo'<script type="text/javascript">
                    alert("Usted ahora es premium");
                    window.location.href="../../login/InicioSesion.php";
                </script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../style/perfil.css">
    <link rel="stylesheet" type="text/css" href="../../styles/base.css">
    <link rel="stylesheet" type="text/css" href="../../styles/componentes.css">
    <link rel="stylesheet" type="text/css" href="../../styles/modoOscuro.css">
    <title>Kindlen`t</title>
    <link rel="icon" href="../../assets/icono.svg" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body id="body">
    <header class="header">
        <div class="header-logo">
            <a href="index.php">
                <svg width="161" height="36" viewBox="0 0 161 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30.279 30L21.897 19.737V30H17.277V6.966H21.897V17.295L30.279 6.966H35.856L26.352 18.384L36.12 30H30.279ZM41.1388 9.54C40.3248 9.54 39.6428 9.287 39.0928 8.781C38.5648 8.253 38.3008 7.604 38.3008 6.834C38.3008 6.064 38.5648 5.426 39.0928 4.92C39.6428 4.392 40.3248 4.128 41.1388 4.128C41.9528 4.128 42.6238 4.392 43.1518 4.92C43.7018 5.426 43.9768 6.064 43.9768 6.834C43.9768 7.604 43.7018 8.253 43.1518 8.781C42.6238 9.287 41.9528 9.54 41.1388 9.54ZM43.4158 11.718V30H38.7958V11.718H43.4158ZM57.7484 11.454C59.9264 11.454 61.6864 12.147 63.0284 13.533C64.3704 14.897 65.0414 16.811 65.0414 19.275V30H60.4214V19.902C60.4214 18.45 60.0584 17.339 59.3324 16.569C58.6064 15.777 57.6164 15.381 56.3624 15.381C55.0864 15.381 54.0744 15.777 53.3264 16.569C52.6004 17.339 52.2374 18.45 52.2374 19.902V30H47.6174V11.718H52.2374V13.995C52.8534 13.203 53.6344 12.587 54.5804 12.147C55.5484 11.685 56.6044 11.454 57.7484 11.454ZM67.8838 20.793C67.8838 18.945 68.2468 17.306 68.9728 15.876C69.7208 14.446 70.7328 13.346 72.0088 12.576C73.2848 11.806 74.7038 11.421 76.2658 11.421C77.4538 11.421 78.5868 11.685 79.6648 12.213C80.7428 12.719 81.6008 13.401 82.2388 14.259V5.58H86.9248V30H82.2388V27.294C81.6668 28.196 80.8638 28.922 79.8298 29.472C78.7958 30.022 77.5968 30.297 76.2328 30.297C74.6928 30.297 73.2848 29.901 72.0088 29.109C70.7328 28.317 69.7208 27.206 68.9728 25.776C68.2468 24.324 67.8838 22.663 67.8838 20.793ZM82.2718 20.859C82.2718 19.737 82.0518 18.78 81.6118 17.988C81.1718 17.174 80.5778 16.558 79.8298 16.14C79.0818 15.7 78.2788 15.48 77.4208 15.48C76.5628 15.48 75.7708 15.689 75.0448 16.107C74.3188 16.525 73.7248 17.141 73.2628 17.955C72.8228 18.747 72.6028 19.693 72.6028 20.793C72.6028 21.893 72.8228 22.861 73.2628 23.697C73.7248 24.511 74.3188 25.138 75.0448 25.578C75.7928 26.018 76.5848 26.238 77.4208 26.238C78.2788 26.238 79.0818 26.029 79.8298 25.611C80.5778 25.171 81.1718 24.555 81.6118 23.763C82.0518 22.949 82.2718 21.981 82.2718 20.859ZM95.694 5.58V30H91.074V5.58H95.694ZM116.891 20.463C116.891 21.123 116.847 21.717 116.759 22.245H103.394C103.504 23.565 103.966 24.599 104.78 25.347C105.594 26.095 106.595 26.469 107.783 26.469C109.499 26.469 110.72 25.732 111.446 24.258H116.429C115.901 26.018 114.889 27.47 113.393 28.614C111.897 29.736 110.06 30.297 107.882 30.297C106.122 30.297 104.538 29.912 103.13 29.142C101.744 28.35 100.655 27.239 99.8626 25.809C99.0926 24.379 98.7076 22.729 98.7076 20.859C98.7076 18.967 99.0926 17.306 99.8626 15.876C100.633 14.446 101.711 13.346 103.097 12.576C104.483 11.806 106.078 11.421 107.882 11.421C109.62 11.421 111.171 11.795 112.535 12.543C113.921 13.291 114.988 14.358 115.736 15.744C116.506 17.108 116.891 18.681 116.891 20.463ZM112.106 19.143C112.084 17.955 111.655 17.009 110.819 16.305C109.983 15.579 108.96 15.216 107.75 15.216C106.606 15.216 105.638 15.568 104.846 16.272C104.076 16.954 103.603 17.911 103.427 19.143H112.106ZM130.031 11.454C132.209 11.454 133.969 12.147 135.311 13.533C136.653 14.897 137.324 16.811 137.324 19.275V30H132.704V19.902C132.704 18.45 132.341 17.339 131.615 16.569C130.889 15.777 129.899 15.381 128.645 15.381C127.369 15.381 126.357 15.777 125.609 16.569C124.883 17.339 124.52 18.45 124.52 19.902V30H119.9V11.718H124.52V13.995C125.136 13.203 125.917 12.587 126.863 12.147C127.831 11.685 128.887 11.454 130.031 11.454ZM142.278 6.966H147.129L143.565 15.282H140.397L142.278 6.966ZM155.458 15.513V24.357C155.458 24.973 155.601 25.424 155.887 25.71C156.195 25.974 156.701 26.106 157.405 26.106H159.55V30H156.646C152.752 30 150.805 28.108 150.805 24.324V15.513H148.627V11.718H150.805V7.197H155.458V11.718H159.55V15.513H155.458Z" fill="#F6F6F6"></path>
                    <path d="M15 33.3H160.606V34.95H15V33.3Z" fill="#F6F6F6"></path>
                    <path d="M19 7H3.75C2.75544 7 1.70326 7.78111 1 8.5C0.296739 9.21889 0 9.81667 0 10.8333V26.1667C0 27.1833 0.395088 28.1584 1.09835 28.8772C1.80161 29.5961 2.75544 30 3.75 30H18.75C19.0815 30 19.3995 29.8654 19.6339 29.6257C19.8683 29.3861 20 29.0611 20 28.7222V8.27778C20 7.93889 19.8683 7.61388 19.6339 7.37425C19.3995 7.13462 19.3315 7 19 7ZM3.75 27.4444C3.41848 27.4444 3.10054 27.3098 2.86612 27.0702C2.6317 26.8306 2.5 26.5056 2.5 26.1667C2.5 25.8278 2.6317 25.5028 2.86612 25.2631C3.10054 25.0235 3.41848 24.8889 3.75 24.8889H17.5V27.4444H3.75Z" fill="#F6F6F6"></path>
                </svg>
            </a>
        </div>
    </header>
    <main class="main" id="main">
        <section class="seccion-perfil" id="seccion-perfil">
            <div class="tipo-suscripcion-premium">
                <div class="tipo-suscripcion-titulo">
                    <h2>Acceso Completo</h2>
                    <h3>$500AR por mes</h3>
                </div>

                <div class="tipo-suscripcion-detalle">
                    <?php if(!empty($mensaje)): ?>
                        <p> <?= $mensaje ?></p>
                    <?php endif; ?>
                    <p>
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 6L2.4 3.6L7.2 8.4L15.6 0L18 2.4L7.2 13.2L0 6Z" fill="#1A1A1A" />
                        </svg>
                        Acceso al catalogo basico
                    </p>
                    <p>
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 6L2.4 3.6L7.2 8.4L15.6 0L18 2.4L7.2 13.2L0 6Z" fill="#1A1A1A" />
                        </svg>
                        Acceso al catalogo Premium
                    </p>
                    <p>
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 6L2.4 3.6L7.2 8.4L15.6 0L18 2.4L7.2 13.2L0 6Z" fill="#1A1A1A" />
                        </svg>
                        Agregar libros a favoritos
                    </p>
                    <p>
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 6L2.4 3.6L7.2 8.4L15.6 0L18 2.4L7.2 13.2L0 6Z" fill="#1A1A1A" />
                        </svg>
                        Tema Oscuro
                    </p>
                    <p>
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 6L2.4 3.6L7.2 8.4L15.6 0L18 2.4L7.2 13.2L0 6Z" fill="#1A1A1A" />
                        </svg>
                        Recomendaciones Personalizadas
                    </p>
                </div>
                <div>
                    <form id="form-registro" action="premium.php" class="registro-izq-form" method="POST">
                        <div class="registro-form-input">
                            <label for="númeroTarjeta">Tarjeta de Crédito</label>
                            <input type="int" name="númeroTarjeta" id="númeroTarjeta" required minlength="16" maxlength="16" pattern="[0-9]+">
                        </div>
                        <div class="registro-form-input">
                            <label for="seguridadTarjeta">Número de seguridad de tarjeta de Crédito</label>
                            <input type="int" name="seguridadTarjeta" id="seguridadTarjeta" required minlength="3" maxlength="3" pattern="[0-9]+">
                        </div>
                        <div class="tipo-suscripcion-button">
                            <!-- <button id="suscripcion-premium">Suscribirse</button> -->
                            <input type="submit" value="Registro premium" name="suscripcion-premium" id="suscripcion-premium"></button>
                        </div>                        
                    </form>
                </div>                
                <a href="index.php" >Volver</a>                
                <a href="../../login/InicioSesion.php" >Inciar sesión</a>
            </div>
        </section>
    </main>

<script type="module" src="script.js"></script>


</body>

</html>