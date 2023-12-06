<!DOCTYPE html>
<html lang="en">
 <!-- // OBTENER VARIABLE DE SESSION , EN SU DEFECTO, MANDAR A LOGIN -->
<?php include 'getStorageScripts.php'; ?>

<?php include 'head.php'; ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'menu.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include 'barTop.php'; ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Total de Visitas</h3>
                        </div>
                        <div class="widget-body">
                            <p id="visits-count">1234</p>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Logout Modal-->
    <?php include 'logoutModal.php'; ?>
    <?php include 'scripts.php'; ?>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-firestore-compat.js"></script>
    <script src="../firebaseAccess.js"></script>
    <script src="../logOut.js"></script>
    <script src="../updateProfile.js"></script>
</body>

</html>
<style>
    .widget {
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: white;
        box-shadow: 0px 0px 10px #aaa;
        width: 200px;
        margin: 20px;
    }

    .widget-header {
        background-color: #f4f4f4;
        border-bottom: 1px solid #ddd;
        padding: 10px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .widget-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .widget-body {
        padding: 15px;
        text-align: center;
    }

    .widget-body p {
        margin: 0;
        font-size: 24px;
        color: #666;
    }
</style>